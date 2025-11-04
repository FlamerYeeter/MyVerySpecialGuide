<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OracleAuthController extends Controller
{
    // Register a guardian/user into Oracle USER_GUARDIAN table
    public function registerGuardian(Request $request)
    {
        // minimal validation
        $data = $request->only(['first_name','last_name','email','password','role']);
        if (empty($data['email']) || empty($data['password'])) {
            return response()->json(['ok' => false, 'error' => 'email_and_password_required'], 400);
        }

        try {
            // include Oracle connection helper (do NOT modify oracledb.php)
            require_once public_path('db/oracledb.php');
            $conn = getOracleConnection();
            if (!$conn) {
                Log::error('OracleAuth::registerGuardian failed to obtain Oracle connection');
                return response()->json(['ok' => false, 'error' => 'oracle_connection_failed'], 500);
            }

            // hash password
            $hash = password_hash($data['password'], PASSWORD_BCRYPT);

            // check for duplicate email (case-insensitive)
            $checkSql = "SELECT ID FROM USER_GUARDIAN WHERE LOWER(EMAIL) = LOWER(:email)";
            $checkStid = @oci_parse($conn, $checkSql);
            if ($checkStid) {
                oci_bind_by_name($checkStid, ':email', $data['email']);
                $okc = @oci_execute($checkStid);
                if ($okc) {
                    $row = oci_fetch_array($checkStid, OCI_ASSOC + OCI_RETURN_NULLS);
                    if ($row && !empty($row['ID'])) {
                        Log::info('OracleAuth register prevented duplicate email', ['email' => $data['email']]);
                        return response()->json(['ok' => false, 'error' => 'email_exists', 'id' => $row['ID']], 409);
                    }
                } else {
                    $e = oci_error($checkStid);
                    Log::warning('OracleAuth register duplicate-check failed: ' . ($e['message'] ?? 'unknown'));
                    // proceed (we'll still try to insert and let Oracle handle unique constraints)
                }
            }

            // prepare insert - set sensible defaults for columns we don't receive
            $sql = "INSERT INTO USER_GUARDIAN (ROLE, FIRST_NAME, LAST_NAME, EMAIL, CONTACT_NUMBER, PASSWORD, EMAIL_VERIFIED, APPROVAL_STATUS) VALUES (:role, :fname, :lname, :email, :contact, :pwd, :ev, :status) RETURNING ID INTO :rid";
            $stid = oci_parse($conn, $sql);

            $role = $data['role'] ?? 'guardian';
            $fname = $data['first_name'] ?? null;
            $lname = $data['last_name'] ?? null;
            $email = $data['email'];
            $contact = $request->input('contact_number', null);
            $ev = 'N';
            $status = 'Pending';

            oci_bind_by_name($stid, ':role', $role);
            oci_bind_by_name($stid, ':fname', $fname);
            oci_bind_by_name($stid, ':lname', $lname);
            oci_bind_by_name($stid, ':email', $email);
            oci_bind_by_name($stid, ':contact', $contact);
            oci_bind_by_name($stid, ':pwd', $hash);
            oci_bind_by_name($stid, ':ev', $ev);
            oci_bind_by_name($stid, ':status', $status);

            // bind returning id
            $rid = 0;
            oci_bind_by_name($stid, ':rid', $rid, 32);

            $ok = @oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
            if (!$ok) {
                $e = oci_error($stid);
                $msg = $e['message'] ?? 'unknown';
                Log::warning('OracleAuth register failed: ' . $msg);
                // detect typical duplicate key / unique constraint errors in Oracle
                if (stripos($msg, 'unique') !== false || stripos($msg, 'unique constraint') !== false || stripos($msg, 'ORA-00001') !== false) {
                    return response()->json(['ok' => false, 'error' => 'email_exists', 'detail' => $msg], 409);
                }
                return response()->json(['ok' => false, 'error' => 'insert_failed', 'detail' => $msg], 500);
            }

            // use a stable session uid for Laravel codepaths
            $sessionUid = 'oracle_' . (string)$rid;
            session(['firebase_uid' => $sessionUid]);

            return response()->json(['ok' => true, 'uid' => $sessionUid, 'id' => $rid]);
        } catch (\Throwable $e) {
            Log::error('OracleAuth::registerGuardian exception: ' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => 'exception', 'message' => $e->getMessage()], 500);
        }
    }

    // Login endpoint: verify email+password against USER_GUARDIAN
    public function loginGuardian(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        if (empty($email) || empty($password)) {
            return response()->json(['ok' => false, 'error' => 'email_and_password_required'], 400);
        }

        try {
            require_once public_path('db/oracledb.php');
            $conn = getOracleConnection();

            $sql = "SELECT ID, PASSWORD, EMAIL_VERIFIED, APPROVAL_STATUS FROM USER_GUARDIAN WHERE LOWER(EMAIL) = LOWER(:email)";
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':email', $email);
            $ok = @oci_execute($stid);
            if (!$ok) {
                $e = oci_error($stid);
                Log::warning('OracleAuth login select failed: ' . ($e['message'] ?? 'unknown'));
                return response()->json(['ok' => false, 'error' => 'select_failed'], 500);
            }
            $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
            if (!$row) {
                return response()->json(['ok' => false, 'error' => 'not_found'], 404);
            }
            $hash = $row['PASSWORD'] ?? null;
            $id = $row['ID'] ?? null;
            $verified = $row['EMAIL_VERIFIED'] ?? 'N';
            $approval = $row['APPROVAL_STATUS'] ?? null;

            if (empty($hash) || !password_verify($password, $hash)) {
                return response()->json(['ok' => false, 'error' => 'invalid_credentials'], 401);
            }

            // set session key so RecommendationController will pick it up
            $sessionUid = 'oracle_' . (string)$id;
            session(['firebase_uid' => $sessionUid]);

            return response()->json(['ok' => true, 'uid' => $sessionUid, 'email_verified' => $verified, 'approval_status' => $approval]);
        } catch (\Throwable $e) {
            Log::error('OracleAuth::loginGuardian exception: ' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => 'exception', 'message' => $e->getMessage()], 500);
        }
    }
}
