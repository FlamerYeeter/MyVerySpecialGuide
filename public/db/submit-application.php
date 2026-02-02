<?php
// Simple endpoint to receive application form (FormData with optional files)
// Expects: job_id, guardian_id, first_name, last_name, email, date_of_birth (YYYY-MM-DD), phone_number, complete_address
// Optional files via keys: medical, resume, pwd
header('Content-Type: application/json; charset=utf-8');

try {
    // basic POST-only guard
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Invalid method');

    // load Oracle helper in the same folder
    require_once __DIR__ . '/oracledb.php';
    $conn = getOracleConnection();
    if (!$conn) throw new Exception('DB connection failed');

    // sanitize inputs (simple)
    $job_id = null;
    // 1) common POST / REQUEST keys
    if (!empty($_POST['job_id'])) {
        $job_id = preg_replace('/\D/', '', (string)$_POST['job_id']);
    } elseif (!empty($_REQUEST['job_id'])) {
        $job_id = preg_replace('/\D/', '', (string)$_REQUEST['job_id']);
    } elseif (!empty($_REQUEST['id'])) {
        $job_id = preg_replace('/\D/', '', (string)$_REQUEST['id']);
    } else {
        // 2) attempt to parse JSON body if client accidentally sent JSON
        $raw = file_get_contents('php://input');
        if ($raw) {
            $j = json_decode($raw, true);
            if (!empty($j['job_id'])) $job_id = preg_replace('/\D/', '', (string)$j['job_id']);
            if (empty($job_id) && !empty($j['id'])) $job_id = preg_replace('/\D/', '', (string)$j['id']);
        }
    }

    // 3) attempt to extract job_id from Referer query string (useful when form submitted from review page with ?job_id=)
    if (empty($job_id) && !empty($_SERVER['HTTP_REFERER'])) {
        $ref = $_SERVER['HTTP_REFERER'];
        $qp = parse_url($ref, PHP_URL_QUERY);
        if ($qp) {
            parse_str($qp, $parr);
            if (!empty($parr['job_id'])) $job_id = preg_replace('/\D/', '', (string)$parr['job_id']);
            if (empty($job_id) && !empty($parr['id'])) $job_id = preg_replace('/\D/', '', (string)$parr['id']);
        }
    }

    // normalize empty string -> null
    if ($job_id === '') $job_id = null;
    // preserve the original posted job id (digits-only) so JOB_CAPACITY can still record it
    $posted_job_id = $job_id;
    $guardian_id = isset($_POST['guardian_id']) && $_POST['guardian_id'] !== '' ? $_POST['guardian_id'] : null;
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    // accept date_of_birth in ISO format (YYYY-MM-DD) — we store age (years) in DB
    $date_of_birth = isset($_POST['date_of_birth']) && $_POST['date_of_birth'] !== '' ? trim($_POST['date_of_birth']) : null;
    $age = null;
    if ($date_of_birth) {
        try {
            $dob_dt = new DateTime($date_of_birth);
            $now_dt = new DateTime();
            $age = $now_dt->diff($dob_dt)->y;
        } catch (Exception $e) {
            $age = null;
        }
    }
    $phone = isset($_POST['phone_number']) ? $_POST['phone_number'] : null;
    $address = isset($_POST['complete_address']) ? $_POST['complete_address'] : null;

    // try to find company_id from JOB_POSTINGS if job_id provided
    $company_id = null;
    $company_name_from_job = null;
    $matched_job_db_id = null; // the actual JOB_POSTINGS.ID when we find a match

    if (!empty($job_id)) {
        // Attempt 1: TO_NUMBER bind (works for normal numeric strings)
        $sql = "SELECT ID, COMPANY_ID, COMPANY_NAME FROM MVSG.JOB_POSTINGS WHERE ID = TO_NUMBER(:jid)";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':jid', $job_id, 0);
        @oci_execute($stid);
        $r = oci_fetch_assoc($stid);
        oci_free_statement($stid);

        if ($r && isset($r['ID'])) {
            $matched_job_db_id = $r['ID'];
            if (!empty($r['COMPANY_ID'])) $company_id = $r['COMPANY_ID'];
            if (!empty($r['COMPANY_NAME'])) $company_name_from_job = $r['COMPANY_NAME'];
        } else {
            // Attempt 2: compare textual representation of ID
            $sql = "SELECT ID, COMPANY_ID, COMPANY_NAME FROM MVSG.JOB_POSTINGS WHERE TO_CHAR(ID) = :jid_str";
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':jid_str', $job_id, 0);
            @oci_execute($stid);
            $r2 = oci_fetch_assoc($stid);
            oci_free_statement($stid);
            if ($r2 && isset($r2['ID'])) {
                $matched_job_db_id = $r2['ID'];
                if (!empty($r2['COMPANY_ID'])) $company_id = $r2['COMPANY_ID'];
                if (!empty($r2['COMPANY_NAME'])) $company_name_from_job = $r2['COMPANY_NAME'];
            } else {
                // Attempt 3: numeric cast and bind as integer
                $jid_int = intval($job_id);
                if ($jid_int > 0) {
                    $sql = "SELECT ID, COMPANY_ID, COMPANY_NAME FROM MVSG.JOB_POSTINGS WHERE ID = :jid_int";
                    $stid = oci_parse($conn, $sql);
                    oci_bind_by_name($stid, ':jid_int', $jid_int, -1);
                    @oci_execute($stid);
                    $r3 = oci_fetch_assoc($stid);
                    oci_free_statement($stid);
                    if ($r3 && isset($r3['ID'])) {
                        $matched_job_db_id = $r3['ID'];
                        if (!empty($r3['COMPANY_ID'])) $company_id = $r3['COMPANY_ID'];
                        if (!empty($r3['COMPANY_NAME'])) $company_name_from_job = $r3['COMPANY_NAME'];
                    }
                }
            }
        }
    }

    // If we matched a JOB_POSTINGS row, prefer inserting that DB ID (ensures FK linkage)
    if (!empty($matched_job_db_id)) {
        $job_id = $matched_job_db_id;
    } else {
        // No matching job_postings row — clear job_id to avoid inserting a non-matching value.
        $job_id = null;
    }

    // fallback: if client explicitly provided company_id in POST, use it
    if (empty($company_id) && !empty($_POST['company_id'])) {
        $company_id = preg_replace('/\D/', '', (string)$_POST['company_id']);
    }

    // fallback: if client sent company_name, try to resolve into COMPANY.ID
    $posted_company_name = isset($_POST['company_name']) ? trim($_POST['company_name']) : (isset($_REQUEST['company_name']) ? trim($_REQUEST['company_name']) : null);
    if (empty($company_id) && !empty($posted_company_name)) {
        $sql = "SELECT ID FROM MVSG.COMPANY WHERE LOWER(COMPANY_NAME) = LOWER(:cname) AND ROWNUM = 1";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':cname', $posted_company_name);
        if (@oci_execute($stid)) {
            $cr = oci_fetch_assoc($stid);
            if ($cr && isset($cr['ID'])) $company_id = $cr['ID'];
        }
        oci_free_statement($stid);
    }

    // fallback: if job_postings had a COMPANY_NAME but no company_id, try to find it
    if (empty($company_id) && !empty($company_name_from_job)) {
        $sql = "SELECT ID FROM MVSG.COMPANY WHERE LOWER(COMPANY_NAME) = LOWER(:cname) AND ROWNUM = 1";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':cname', $company_name_from_job);
        if (@oci_execute($stid)) {
            $cr = oci_fetch_assoc($stid);
            if ($cr && isset($cr['ID'])) $company_id = $cr['ID'];
        }
        oci_free_statement($stid);
    }

    if (empty($company_id) && !empty($job_id)) {
        $job_id_int = intval($job_id);
        if ($job_id_int > 0) {
            $sql = "SELECT COMPANY_ID FROM MVSG.JOB_POSTINGS WHERE ID = :jid_int";
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':jid_int', $job_id_int, -1);
            oci_execute($stid);
            $r2 = oci_fetch_assoc($stid);
            if ($r2 && array_key_exists('COMPANY_ID', $r2) && $r2['COMPANY_ID'] !== null && $r2['COMPANY_ID'] !== '') {
                $company_id = $r2['COMPANY_ID'];
            }
            oci_free_statement($stid);
        }
    }

    // prepare file contents (read tmp files)
    $med_content = null; $res_content = null; $pwd_content = null;
    if (!empty($_FILES['medical']['tmp_name'])) $med_content = file_get_contents($_FILES['medical']['tmp_name']);
    if (!empty($_FILES['resume']['tmp_name'])) $res_content = file_get_contents($_FILES['resume']['tmp_name']);
    if (!empty($_FILES['pwd']['tmp_name'])) $pwd_content = file_get_contents($_FILES['pwd']['tmp_name']);

    // Build INSERT with EMPTY_BLOB() placeholders and RETURNING LOB locators
        $insertSql = "INSERT INTO MVSG.APPLICATIONS 
            (JOB_POSTING_ID, COMPANY_ID, GUARDIAN_ID, FIRST_NAME, LAST_NAME, EMAIL, AGE, PHONE_NUMBER, COMPLETE_ADDRESS, MEDICAL_CERTIFICATE, RESUME_CV, PWD_ID, CREATED_AT)
                VALUES (:job_id, :company_id, :guardian_id, :first_name, :last_name, :email, :age, :phone, :address, EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB(), SYSTIMESTAMP)
            RETURNING ID, MEDICAL_CERTIFICATE, RESUME_CV, PWD_ID INTO :new_id, :med_blob, :res_blob, :pwd_blob";

    $stid = oci_parse($conn, $insertSql);

    // bind scalar params
    oci_bind_by_name($stid, ':job_id', $job_id);
    oci_bind_by_name($stid, ':company_id', $company_id);
    oci_bind_by_name($stid, ':guardian_id', $guardian_id);
    oci_bind_by_name($stid, ':first_name', $first_name);
    oci_bind_by_name($stid, ':last_name', $last_name);
    oci_bind_by_name($stid, ':email', $email);
    oci_bind_by_name($stid, ':age', $age);
    oci_bind_by_name($stid, ':phone', $phone);
    oci_bind_by_name($stid, ':address', $address);

    // create LOB descriptors for returning INTO
    $medBlob = oci_new_descriptor($conn, OCI_D_LOB);
    $resBlob = oci_new_descriptor($conn, OCI_D_LOB);
    $pwdBlob = oci_new_descriptor($conn, OCI_D_LOB);

    oci_bind_by_name($stid, ':new_id', $new_id, 32);
    oci_bind_by_name($stid, ':med_blob', $medBlob, -1, OCI_B_BLOB);
    oci_bind_by_name($stid, ':res_blob', $resBlob, -1, OCI_B_BLOB);
    oci_bind_by_name($stid, ':pwd_blob', $pwdBlob, -1, OCI_B_BLOB);

    // execute without auto-commit so we can stream LOBs and then commit
    if (!@oci_execute($stid, OCI_NO_AUTO_COMMIT)) {
        $e = oci_error($stid);
        throw new Exception('Insert failed: ' . ($e['message'] ?? 'unknown'));
    }

    // write blobs if present
    if ($med_content !== null) {
        if (!$medBlob->save($med_content)) throw new Exception('Failed to save medical blob');
    }
    if ($res_content !== null) {
        if (!$resBlob->save($res_content)) throw new Exception('Failed to save resume blob');
    }
    if ($pwd_content !== null) {
        if (!$pwdBlob->save($pwd_content)) throw new Exception('Failed to save pwd blob');
    }

    // --- insert into JOB_CAPACITY (best-effort within same transaction) ----------------
    // debug diagnostics for capacity insert
    $__jobcap_debug = [];

    try {
        if (!empty($guardian_id) && (!empty($job_id) || !empty($posted_job_id))) {
            // prefer the matched DB id when available, otherwise fall back to the original posted id
            $cap_job_id = !empty($matched_job_db_id) ? $matched_job_db_id : $posted_job_id;

            // try to find a readable role/title from JOB_POSTINGS (use resolved id when possible)
            $job_role = null;
            $cap_job_id_str = (string)$cap_job_id;
            // If numeric id is longer than Oracle NUMBER precision, use TO_CHAR matching
            $use_to_char = strlen($cap_job_id_str) > 38;
            if ($use_to_char) {
                $jsql = "SELECT JOB_TITLE, JOB_ROLE, ROLE FROM MVSG.JOB_POSTINGS WHERE TO_CHAR(ID) = :jid_str";
            } else {
                $jsql = "SELECT JOB_TITLE, JOB_ROLE, ROLE FROM MVSG.JOB_POSTINGS WHERE ID = TO_NUMBER(:jid_str)";
            }
            $jst = @oci_parse($conn, $jsql);
            if ($jst) {
                oci_bind_by_name($jst, 'jid_str', $cap_job_id_str, -1);
                if (@oci_execute($jst)) {
                    $jr = oci_fetch_assoc($jst);
                    if ($jr) {
                        // prefer JOB_TITLE as the role label per requirement
                        $job_role = trim((string)($jr['JOB_TITLE'] ?? $jr['JOB_ROLE'] ?? $jr['ROLE'] ?? '')) ?: null;
                    }
                }
                @oci_free_statement($jst);
            }

            $role_to_use = $job_role ?? null;

            // bind numeric ids as strings and convert with TO_NUMBER in SQL to avoid bind-name issues
            $capSql = "INSERT INTO MVSG.JOB_CAPACITY (JOB_POSTING_ID, USER_ID, ROLE, CREATED_AT, UPDATED_AT, STATUS) VALUES (TO_NUMBER(:b_jid), TO_NUMBER(:b_uid), :b_role, SYSTIMESTAMP, SYSTIMESTAMP, 'Pending')";
            $capSt = @oci_parse($conn, $capSql);
            if ($capSt) {
                // bind names without leading colon and set lengths where appropriate
                $rbind = $role_to_use !== null ? $role_to_use : null;
                $bj = (string)$cap_job_id;
                $bu = (string)$guardian_id;
                oci_bind_by_name($capSt, 'b_jid', $bj, -1);
                oci_bind_by_name($capSt, 'b_uid', $bu, -1);
                oci_bind_by_name($capSt, 'b_role', $rbind, 4000);
                $ok = @oci_execute($capSt);
                $__jobcap_debug['insert_ok'] = $ok ? true : false;
                if (!$ok) {
                    $err = oci_error($capSt) ?: [];
                    $__jobcap_debug['insert_error'] = $err;
                    // attempt an update to refresh timestamp/role when unique constraint prevents insert
                    $updSql = "UPDATE MVSG.JOB_CAPACITY SET UPDATED_AT = SYSTIMESTAMP" . ($role_to_use !== null ? ", ROLE = :b_role" : "") . " WHERE JOB_POSTING_ID = TO_NUMBER(:b_jid) AND USER_ID = TO_NUMBER(:b_uid)";
                    $updSt = @oci_parse($conn, $updSql);
                    if ($updSt) {
                        if ($role_to_use !== null) oci_bind_by_name($updSt, 'b_role', $rbind, 4000);
                        oci_bind_by_name($updSt, 'b_jid', $bj, -1);
                        oci_bind_by_name($updSt, 'b_uid', $bu, -1);
                        $uok = @oci_execute($updSt);
                        $__jobcap_debug['update_ok'] = $uok ? true : false;
                        if (!$uok) $__jobcap_debug['update_error'] = oci_error($updSt) ?: [];
                        @oci_free_statement($updSt);
                    }
                }
                @oci_free_statement($capSt);
            } else {
                $__jobcap_debug['parse_failed'] = true;
            }
        }
    } catch (Throwable $e) {
        // ignore capacity logging failures — do not break primary flow
    }

    // commit
    if (!oci_commit($conn)) {
        $e = oci_error($conn);
        throw new Exception('Commit failed: ' . ($e['message'] ?? 'unknown'));
    }

    // --- record apply interaction (best-effort, do not break main flow) ----------------
    try {
        // only log if we have both guardian and job (USER_INTERACTIONS likely requires NOT NULL FKs)
        if (!empty($guardian_id) && !empty($job_id)) {
            if (!isset($_SESSION['ui_logged_apply']) || !is_array($_SESSION['ui_logged_apply'])) {
                $_SESSION['ui_logged_apply'] = [];
            }
            // avoid duplicate logs within session for same application/job
            $sid = (string)($new_id ?: $job_id);
            if (!in_array($sid, $_SESSION['ui_logged_apply'], true)) {
                $insSql = "INSERT INTO MVSG.USER_INTERACTIONS (GUARDIAN_ID, JOB_ID, INTERACTION_TYPE, INTERACTION_AT, META)
                           VALUES (:gid, :jid, :itype, SYSTIMESTAMP, :meta)";
                $insStmt = @oci_parse($conn, $insSql);
                if ($insStmt) {
                    $itype = 'apply';
                    $meta = json_encode(['source' => 'application_form', 'application_id' => $new_id ?: null]);
                    oci_bind_by_name($insStmt, ':gid', $guardian_id);
                    oci_bind_by_name($insStmt, ':jid', $job_id);
                    oci_bind_by_name($insStmt, ':itype', $itype);
                    oci_bind_by_name($insStmt, ':meta', $meta);
                    // execute but do not let a failure break the response
                    @oci_execute($insStmt);
                    @oci_free_statement($insStmt);
                }
                // mark as logged in this session
                $_SESSION['ui_logged_apply'][] = $sid;
            }
        }
    } catch (Throwable $e) {
        // ignore logging failures — they should not affect primary API
    }
    // ---------------------------------------------------------------------------

    // free resources
    $medBlob->free();
    $resBlob->free();
    $pwdBlob->free();
    oci_free_statement($stid);
    oci_close($conn);

    $out = [
        'success' => true,
        'id' => $new_id,
        'job_id_received' => $job_id,
        'company_id_resolved' => $company_id,
        'redirect' => '/job-matches' // client will navigate here if present
    ];
    if (!empty($__jobcap_debug)) $out['jobcap_debug'] = $__jobcap_debug;
    echo json_encode($out);
    exit;
} catch (Exception $ex) {
    // best-effort cleanup
    if (isset($stid) && $stid) @oci_free_statement($stid);
    if (isset($conn) && $conn) @oci_close($conn);
    $msg = $ex->getMessage();
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $msg]);
    exit;
}
?>