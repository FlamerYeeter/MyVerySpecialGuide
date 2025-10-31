<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * RecommendationService
 *
 * Generates hybrid job recommendations (Content-Based + Collaborative)
 */
class RecommendationService
{
    protected $fs;

    public function __construct(FirestoreAdminService $firestoreAdminService)
    {
        $this->fs = $firestoreAdminService;
    }

    /**
     * Generate recommendations for a user
     *
     * @param string $userId Firestore uid
     * @param int $limit number of results to return
     * @return array list of recommended jobs with metadata
     */
    public function generate(string $userId, int $limit = 10): array
    {
        $user = $this->fs->getUser($userId);
        $jobs = $this->fs->listJobs(); // associative jobId => jobData

        // debug: surface job/user counts in CLI runs to diagnose empty outputs
        $jobsCount = is_array($jobs) ? count($jobs) : 0;
        // build user text early so we can log its length
        $userText = $this->buildUserText($user);
        try {
            if (php_sapi_name() === 'cli') {
                echo "[RecommendationService] listJobs returned={$jobsCount} docs, userText_len=" . strlen($userText) . "\n";
                // show first job id if present
                if ($jobsCount > 0) {
                    reset($jobs);
                    $firstKey = key($jobs);
                    echo "[RecommendationService] sample_job_id={$firstKey}\n";
                }
            }
        } catch (\Throwable $_dbg) {}

        if (empty($jobs)) return [];

        // Content-based scores
        $cbfScores = [];
        foreach ($jobs as $jobId => $job) {
            $jobText = $this->buildJobText($job);
            $cbfScores[$jobId] = $this->calculateSimilarity($userText, $jobText);
        }

        try {
            if (php_sapi_name() === 'cli') {
                $nonZero = 0; $sample = [];
                foreach ($cbfScores as $k => $v) { if ($v > 0) $nonZero++; if (count($sample) < 5) $sample[$k] = $v; }
                echo "[RecommendationService] cbf_nonzero={$nonZero}, sample_cbf=" . json_encode($sample) . "\n";
            }
        } catch (\Throwable $_dbg) {}

        // Collaborative scores
        $cfScores = $this->calculateCollaborativeScores($userId, $jobs);

        // Combine into hybrid
        $wCbf = 0.6; $wCf = 0.4;
        $hybrid = [];
        foreach ($jobs as $jobId => $job) {
            $cb = $cbfScores[$jobId] ?? 0.0;
            $cf = $cfScores[$jobId] ?? 0.0;
            $score = ($wCbf * $cb) + ($wCf * $cf);

            // Experience-level boost
            $userLevel = $this->inferExperienceLevel($userText);
            $jobLevel = strtolower($job['experience_level'] ?? '');
            if ($jobLevel && Str::contains(strtolower($jobLevel), strtolower($userLevel))) {
                $score += 0.1; // small boost
            }

            // Industry preference boost (if user has explicit preference)
            if (!empty($user['industry_preference']) && !empty($job['industry'])) {
                $pref = strtolower((string)$user['industry_preference']);
                if (Str::contains(strtolower($job['industry']), $pref)) {
                    $score += 0.08;
                }
            }

            // Recency boost (if job has posted_at/created_at)
            $posted = $job['posted_at'] ?? $job['created_at'] ?? null;
            if ($posted) {
                $ageDays = $this->ageDays($posted);
                if ($ageDays !== null && $ageDays <= 14) {
                    // recent within 2 weeks
                    $score += 0.05;
                }
            }

            $hybrid[$jobId] = max(0, $score);
        }

        arsort($hybrid);
        $top = array_slice($hybrid, 0, $limit, true);

        $out = [];
        foreach ($top as $jobId => $score) {
            $job = $jobs[$jobId] ?? [];
            $out[] = [
                'id' => $jobId,
                'title' => $job['title'] ?? '',
                'company' => $job['company'] ?? '',
                'score' => round($score, 4),
                'cbf' => $cbfScores[$jobId] ?? 0.0,
                'cf' => $cfScores[$jobId] ?? 0.0,
                'data' => $job,
            ];
        }

        return $out;
    }

    protected function buildUserText(?array $user): string
    {
        if (empty($user) || !is_array($user)) return '';
        $parts = [];

        // Helper to safely append text (strings or arrays)
        $append = function($v) use (&$parts) {
            if (is_array($v)) {
                // flatten arrays recursively
                $flat = [];
                array_walk_recursive($v, function($it) use (&$flat) { if ($it !== null && $it !== '') $flat[] = (string)$it; });
                if (!empty($flat)) $parts[] = implode(' ', $flat);
            } elseif ($v !== null && $v !== '') {
                $parts[] = (string)$v;
            }
        };

        // Common top-level keys
        foreach (['resume_text','title','summary'] as $k) {
            if (!empty($user[$k])) $append($user[$k]);
        }

        // Profile fields often stored as nested maps in Firestore (skills, jobPreferences, workplace, supportNeed, personalInfo, educationInfo, workExperience)
        if (!empty($user['skills'])) {
            // skills may be an array or map with skills_page1/skills_page2 containing JSON strings
            $s = $user['skills'];
            if (is_array($s)) {
                // if nested keys exist, extract likely fields
                foreach (['skills_page1','skills_page2','skills'] as $sk) {
                    if (isset($s[$sk])) {
                        $val = $s[$sk];
                        // sometimes stored as JSON-encoded string
                        if (is_string($val)) {
                            $decoded = json_decode($val, true);
                            if (is_array($decoded)) $append($decoded); else $append($val);
                        } else {
                            $append($val);
                        }
                    }
                }
                // also include any other scalar values
                foreach ($s as $k => $v) if (!in_array($k, ['skills_page1','skills_page2','skills'])) $append($v);
            } else {
                $append($s);
            }
        }

        if (!empty($user['jobPreferences'])) {
            $jp = $user['jobPreferences'];
            if (is_array($jp)) {
                foreach (['jobpref1','jobpref_1','jobpref2','jobpref_3'] as $k) {
                    if (isset($jp[$k])) {
                        $val = $jp[$k];
                        if (is_string($val)) {
                            $decoded = json_decode($val, true);
                            if (is_array($decoded)) $append($decoded); else $append($val);
                        } else {
                            $append($val);
                        }
                    }
                }
            } else {
                $append($jp);
            }
        }

        if (!empty($user['workplace'])) {
            $wp = $user['workplace'];
            if (is_array($wp) && isset($wp['workplace_choice'])) $append($wp['workplace_choice']);
            else $append($wp);
        }

        if (!empty($user['supportNeed'])) {
            $sn = $user['supportNeed'];
            if (is_array($sn) && isset($sn['support_choice'])) $append($sn['support_choice']);
            else $append($sn);
        }

        // personal info (name, role, email)
        if (!empty($user['personalInfo'])) {
            $pi = $user['personalInfo'];
            if (is_array($pi)) {
                foreach (['first','last','role','email'] as $k) if (isset($pi[$k])) $append($pi[$k]);
            } else $append($pi);
        } else {
            foreach (['first','last','role','email'] as $k) if (isset($user[$k])) $append($user[$k]);
        }

        // education/work experience
        if (!empty($user['educationInfo'])) $append($user['educationInfo']);
        if (!empty($user['workExperience'])) $append($user['workExperience']);

        // Finally, add any top-level keys that are likely relevant
        foreach (['experience','education','skills','industry_preference'] as $k) {
            if (isset($user[$k])) $append($user[$k]);
        }

        return strtolower(implode(' ', $parts));
    }

    protected function buildJobText(array $job): string
    {
        $parts = [];
        foreach (['title','description','skills','industry','company','experience_level','location'] as $k) {
            if (!empty($job[$k])) {
                if (is_array($job[$k])) {
                    // flatten nested arrays/maps into scalars
                    $flat = [];
                    array_walk_recursive($job[$k], function($it) use (&$flat) { if ($it !== null && $it !== '') $flat[] = (string)$it; });
                    if (!empty($flat)) $parts[] = implode(' ', $flat);
                } else {
                    $parts[] = (string)$job[$k];
                }
            }
        }
        // Also include nested `data` fields commonly present when jobs are imported
        if (!empty($job['data']) && is_array($job['data'])) {
            $flat = [];
            array_walk_recursive($job['data'], function($it) use (&$flat) { if ($it !== null && $it !== '') $flat[] = (string)$it; });
            if (!empty($flat)) $parts[] = implode(' ', $flat);
        }

        return strtolower(implode(' ', $parts));
    }

    /**
     * Calculate TF-IDF + cosine similarity between the user text and job texts.
     * Returns an associative array jobId => similarity (0..1)
     */
    protected function calculateTfIdfSimilarity(string $userText, array $jobsTexts): array
    {
        // jobsTexts: jobId => text
        $docs = $jobsTexts;
        $docs['_user_'] = $userText;
        // tokenize all docs
        $tokenized = [];
        foreach ($docs as $id => $txt) {
            $tokenized[$id] = $this->tokenizeText($txt);
        }

        // build vocabulary and document frequencies
        $vocab = [];
        $df = [];
        foreach ($tokenized as $id => $tokens) {
            $seen = [];
            foreach ($tokens as $t) {
                $vocab[$t] = true;
                if (!isset($seen[$t])) { $df[$t] = ($df[$t] ?? 0) + 1; $seen[$t] = true; }
            }
        }
        $vocabList = array_keys($vocab);
        $N = count($tokenized);
        if ($N <= 1) return array_fill_keys(array_keys($jobsTexts), 0.0);

        // compute IDF
        $idf = [];
        foreach ($vocabList as $t) {
            $idf[$t] = log(($N) / (1 + ($df[$t] ?? 0)) + 1e-9);
        }

        // helper to compute TF-IDF vector (sparse map)
        $computeVec = function($tokens) use ($idf) {
            $tf = [];
            foreach ($tokens as $t) $tf[$t] = ($tf[$t] ?? 0) + 1;
            $vec = [];
            $len = 0.0;
            foreach ($tf as $t => $c) {
                $val = $c * ($idf[$t] ?? 0.0);
                $vec[$t] = $val;
                $len += $val * $val;
            }
            $len = sqrt($len);
            return ['vec' => $vec, 'len' => $len];
        };

        $vectors = [];
        foreach ($tokenized as $id => $tokens) {
            $vectors[$id] = $computeVec($tokens);
        }

        // compute cosine similarity between user and each job
        $userV = $vectors['_user_'];
        $out = [];
        foreach ($jobsTexts as $jobId => $_) {
            $jobV = $vectors[$jobId] ?? ['vec' => [], 'len' => 0.0];
            if ($userV['len'] <= 0 || $jobV['len'] <= 0) { $out[$jobId] = 0.0; continue; }
            $dot = 0.0;
            foreach ($jobV['vec'] as $t => $val) {
                if (isset($userV['vec'][$t])) $dot += $val * $userV['vec'][$t];
            }
            $sim = $dot / max(1e-9, ($userV['len'] * $jobV['len']));
            $out[$jobId] = round(max(0.0, min(1.0, $sim)), 4);
        }
        return $out;
    }

    /**
     * Generate both Jaccard (existing) and TF-IDF similarities and return comparison data.
     * Useful for prototyping and comparing distributions.
     */
    public function generateCompare(string $userId, int $limit = 10): array
    {
        $user = $this->fs->getUser($userId);
        $jobs = $this->fs->listJobs();
        if (empty($jobs) || empty($user)) return ['jaccard' => [], 'tfidf' => [], 'context' => []];

        $userText = $this->buildUserText($user);

        $cbfScores = [];
        $jobsTexts = [];
        foreach ($jobs as $jobId => $job) {
            $txt = $this->buildJobText($job);
            $jobsTexts[$jobId] = $txt;
            $cbfScores[$jobId] = $this->calculateSimilarity($userText, $txt);
        }

        $tfidfScores = $this->calculateTfIdfSimilarity($userText, $jobsTexts);

        // context-aware: simple blend + boosts (industry, workplace, experience level)
        $contextScores = [];
        foreach ($jobs as $jobId => $job) {
            $jacc = $cbfScores[$jobId] ?? 0.0;
            $tfid = $tfidfScores[$jobId] ?? 0.0;
            $base = 0.5 * $jacc + 0.5 * $tfid;
            // small boosts
            if (!empty($user['industry_preference']) && !empty($job['industry'])) {
                $pref = strtolower((string)$user['industry_preference']);
                if (strpos(strtolower($job['industry']), $pref) !== false) $base += 0.06;
            }
            // workplace
            if (!empty($user['workplace']) && is_array($user['workplace'])) {
                $w = $user['workplace']['workplace_choice'] ?? null;
                if ($w && isset($job['workplace']) && stripos($job['workplace'], $w) !== false) $base += 0.04;
            }
            // experience level matching
            $userLevel = $this->inferExperienceLevel($userText);
            $jobLevel = strtolower($job['experience_level'] ?? '');
            if ($jobLevel && Str::contains(strtolower($jobLevel), strtolower($userLevel))) $base += 0.03;
            $contextScores[$jobId] = round(max(0.0, $base), 4);
        }

        // sort and slice top by context score for display
        arsort($contextScores);
        $topContext = array_slice($contextScores, 0, $limit, true);

        // return compact comparison
        return [
            'jaccard' => $cbfScores,
            'tfidf' => $tfidfScores,
            'context' => $contextScores,
            'top_context' => $topContext,
        ];
    }

    protected function calculateSimilarity(string $a, string $b): float
    {
        if (trim($a) === '' || trim($b) === '') return 0.0;
        $ta = $this->tokenizeText($a);
        $tb = $this->tokenizeText($b);
        if (empty($ta) || empty($tb)) return 0.0;
        $inter = array_intersect($ta, $tb);
        $interCount = count($inter);
        $unionCount = max(count($ta) + count($tb) - $interCount, 1);
        return round($interCount / $unionCount, 4);
    }

    protected function tokenizeText(string $s): array
    {
        // basic tokenization: remove non-word, split, unique, remove short tokens
        $s = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $s);
        $t = preg_split('/\s+/u', $s, -1, PREG_SPLIT_NO_EMPTY);
        $t = array_map('mb_strtolower', $t);
        $t = array_filter($t, function($w){ return mb_strlen($w) > 2; });
        $t = array_values(array_unique($t));
        return $t;
    }

    protected function calculateCollaborativeScores(string $userId, array $jobs): array
    {
        // Fetch applications data (each has userId and job_id)
        $applications = $this->fs->listApplications(); 
        if (empty($applications)) return [];

        // Build user → job_ids map
        $userToJobs = [];
        foreach ($applications as $app) {
            $u = (string)($app['userId'] ?? $app['user_id'] ?? '');
            $j = (string)($app['job_id'] ?? $app['jobId'] ?? '');
            if ($u !== '' && $j !== '') {
                $userToJobs[$u][] = $j;
            }
        }

        if (empty($userToJobs[$userId] ?? [])) return [];
        $targetJobs = array_unique($userToJobs[$userId]);

        // Compute user–user similarity (Jaccard)
        $similarities = [];
        foreach ($userToJobs as $otherUser => $otherJobs) {
            if ($otherUser === $userId) continue;
            $intersect = array_intersect($targetJobs, $otherJobs);
            $union = array_unique(array_merge($targetJobs, $otherJobs));
            $sim = count($intersect) / max(count($union), 1);
            if ($sim > 0) $similarities[$otherUser] = $sim;
        }

        if (empty($similarities)) return [];

        // Aggregate job recommendations from similar users
        $jobScores = [];
        foreach ($similarities as $otherUser => $simScore) {
            foreach ($userToJobs[$otherUser] as $jobId) {
                if (in_array($jobId, $targetJobs, true)) continue; // already applied
                if (!isset($jobs[$jobId])) continue; // job not active
                $jobScores[$jobId] = ($jobScores[$jobId] ?? 0) + $simScore;
            }
        }

        if (empty($jobScores)) return [];

        // Normalize 0..1
        $maxScore = max($jobScores);
        foreach ($jobScores as $jid => $score) {
            $jobScores[$jid] = round($score / max($maxScore, 1e-9), 4);
        }

        return $jobScores;
    }



    protected function inferExperienceLevel(string $text): string
    {
        $t = strtolower($text);
        if (Str::contains($t, ['senior', 'manager', 'lead', 'sr'])) return 'mid-senior';
        if (Str::contains($t, ['junior', 'jr', 'entry', 'intern', 'graduate'])) return 'entry';
        return 'associate';
    }

    protected function ageDays($date): ?int
    {
        if (!$date) return null;
        try {
            // accept various formats
            $ts = strtotime((string)$date);
            if ($ts === false) return null;
            $diff = time() - $ts;
            return (int)floor($diff / 86400);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
