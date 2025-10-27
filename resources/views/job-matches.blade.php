@extends('layouts.includes')

@section('content')

    <!-- Filter Form -->
    <section class="bg-yellow-400 py-7 mt-4">
        <div class="container mx-auto px-4">
            <form id="filter-form" method="GET" action="{{ route('job.matches') }}">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <img src="{{ asset('image/logo.png') }}" class="w-20 h-20">
                    <div>
                        <h2 class="text-3xl font-bold text-blue-800">Job Recommended For You</h2>
                        <br>
                        <p class="text-sm text-gray-600">(Mga Trabahong Para sa Iyo)</p>
                    </div>
                </div>
        </div>
    </section>
    <section class="max-w-6xl mx-auto mt-8 px-6">
        <h3 class="text-lg font-semibold mb-3">Filter</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    <select name="industry" class="px-4 py-2 rounded-lg bg-white border-2 border-blue-500 text-sm">
                        <option value="">Industry</option>
                        <option value="Healthcare" {{ request('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare
                        </option>
                        <option value="Retail" {{ request('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                        <option value="Food Service" {{ request('industry') == 'Food Service' ? 'selected' : '' }}>Food Service
                        </option>
                        <option value="Education" {{ request('industry') == 'Education' ? 'selected' : '' }}>Education
                        </option>
                        <option value="Hospitality" {{ request('industry') == 'Hospitality' ? 'selected' : '' }}>Hospitality
                        </option>
                        <option value="Manufacturing" {{ request('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing
                        </option>
                        <option value="Transportation" {{ request('industry') == 'Transportation' ? 'selected' : '' }}>Transportation
                        </option>
                        <option value="Cleaning" {{ request('industry') == 'Cleaning' ? 'selected' : '' }}>Cleaning
                        </option>
                        <option value="Office" {{ request('industry') == 'Office' ? 'selected' : '' }}>Office
                        </option>
                        <option value="Construction" {{ request('industry') == 'Construction' ? 'selected' : '' }}>Construction
                        </option>
                        <option value="Creative" {{ request('industry') == 'Creative' ? 'selected' : '' }}>Creative
                        </option>
                        <option value="Packing" {{ request('industry') == 'Packing' ? 'selected' : '' }}>Packing
                        </option>
                        <option value="Other" {{ request('industry') == 'Other' ? 'selected' : '' }}>Other
                        </option>
                    </select>
                    <select name="fit_level" class="px-4 py-2 rounded-lg bg-white border-2 border-blue-500 text-sm">
                        <option value="">Job Fit Level</option>
                        <option value="Excellent Fit" {{ request('fit_level') == 'Excellent Fit' ? 'selected' : '' }}>
                            Excellent Fit</option>
                        <option value="Good Fit" {{ request('fit_level') == 'Good Fit' ? 'selected' : '' }}>Good Fit
                        </option>
                    </select>
                    <select name="growth_potential" class="px-4 py-2 rounded-lg bg-white border-2 border-blue-500 text-sm">
                        <option value="">Growth Potential</option>
                        <option value="High Potential" {{ request('growth_potential') == 'High Potential' ? 'selected' : '' }}>
                            High Potential</option>
                        <option value="Medium Potential" {{ request('growth_potential') == 'Medium Potential' ? 'selected' : '' }}>
                            Medium Potential</option>
                    </select>
                    <select name="work_environment" class="px-4 py-2 rounded-lg bg-white border-2 border-blue-500 text-sm">
                        <option value="">Work Environment</option>
                        <option value="Quiet" {{ request('work_environment') == 'Quiet' ? 'selected' : '' }}>Quiet</option>
                        <option value="Busy" {{ request('work_environment') == 'Busy' ? 'selected' : '' }}>Busy</option>
                    </select>
                    <!-- location filter removed per request -->
                    <!-- Filter is automatic now: selects will submit the form on change -->
                </div>
                
            </form>
            <script>
                // Auto-submit filter selectors (robust): if selects are outside the form or rendered later,
                // this will read their values and navigate to the same route with updated query params.
                document.addEventListener('DOMContentLoaded', function(){
                    try {
                        const selectNames = ['industry','fit_level','growth_potential','work_environment'];
                        const selects = [];
                        selectNames.forEach(name => document.querySelectorAll('select[name="' + name + '"]').forEach(s => selects.push(s)));
                        if (!selects.length) return;
                        let submitTimeout = null;
                        const applyFilters = () => {
                            const params = new URLSearchParams(window.location.search || '');
                            selectNames.forEach(name => {
                                const el = document.querySelector('select[name="' + name + '"]');
                                if (!el) return;
                                const v = el.value;
                                if (v === null || v === '') params.delete(name);
                                else params.set(name, v);
                            });
                            // reset to first page when filters change
                            params.set('page', '1');
                            const newUrl = window.location.pathname + (params.toString() ? ('?' + params.toString()) : '');
                            // navigate
                            window.location.href = newUrl;
                        };
                        selects.forEach(s => s.addEventListener('change', function(){ if (submitTimeout) clearTimeout(submitTimeout); submitTimeout = setTimeout(applyFilters, 120); }));
                    } catch (e) { console.debug('filter auto-submit setup failed', e); }
                });
            </script>

        </div>
        <br>
       <div class="text-center flex flex-col items-center justify-center">
            <p class="text-sm text-gray-600">
            Click the dropdown arrow above, look at the list, and choose the option you want, the system will show jobs that match what you picked.
            </p>
            <p class="text-xs text-gray-500 italic">
            (I-click ang dropdown arrow sa itaas, tingnan ang listahan, at piliin ang gusto mong option, ipapakita ng system ang mga trabahong bagay sa iyong pinili)
            </p>
        </div>

    </section>

    <!-- Match Notice -->
     <!--
    <div class="container mx-auto mt-6 px-4">
        <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-gray-800 font-medium flex items-center">
                💡 These jobs match your skills and preferences!
            </p>
            <p class="italic text-sm text-gray-600">(Ang mga trabahong ito ay tumutugma sa iyong kakayahan at kagustuhan!)</p>
        </div>
-->

        @php
            // Try to load evaluation metrics from public/eval_metrics.json
            $evalPath = public_path('eval_metrics.json');
            $eval = [];
            if (file_exists($evalPath)) {
                $eval = json_decode(@file_get_contents($evalPath), true) ?: [];
            }

            // Normalize common metric keys and/or compute from counts when available
            $metrics = [
                'accuracy' => null,
                'precision' => null,
                'recall' => null,
                'f1' => null,
            ];

            // If file already contains metrics directly, prefer them
            foreach (['accuracy','precision','recall','f1','f1_score'] as $k) {
                if (isset($eval[$k])) {
                    $normalized = $eval[$k];
                    if (is_numeric($normalized)) $metrics[$k === 'f1_score' ? 'f1' : $k] = floatval($normalized);
                }
            }

            // Accept some alternate key names
            if (isset($eval['F1'])) $metrics['f1'] = is_numeric($eval['F1']) ? floatval($eval['F1']) : $metrics['f1'];
            if (isset($eval['Precision'])) $metrics['precision'] = is_numeric($eval['Precision']) ? floatval($eval['Precision']) : $metrics['precision'];
            if (isset($eval['Recall'])) $metrics['recall'] = is_numeric($eval['Recall']) ? floatval($eval['Recall']) : $metrics['recall'];
            if (isset($eval['Accuracy'])) $metrics['accuracy'] = is_numeric($eval['Accuracy']) ? floatval($eval['Accuracy']) : $metrics['accuracy'];

            // Handle a common format where eval_metrics.json contains a `metrics` array (per-model)
            $perModelMetrics = [];
            if (isset($eval['metrics']) && is_array($eval['metrics']) && count($eval['metrics']) > 0) {
                foreach ($eval['metrics'] as $m) {
                    if (!is_array($m)) continue;
                    $modelName = $m['model'] ?? ($m['name'] ?? 'model');
                    $a = isset($m['accuracy']) && is_numeric($m['accuracy']) ? floatval($m['accuracy']) : null;
                    $p = isset($m['precision']) && is_numeric($m['precision']) ? floatval($m['precision']) : null;
                    $r = isset($m['recall']) && is_numeric($m['recall']) ? floatval($m['recall']) : null;
                    $f = null;
                    if (isset($m['f1']) && is_numeric($m['f1'])) $f = floatval($m['f1']);
                    if ($f === null && isset($m['f1_score']) && is_numeric($m['f1_score'])) $f = floatval($m['f1_score']);
                    // convert fractional to percent for display later
                    $convert = function($v) { if ($v === null) return null; $n = floatval($v); return ($n > 0 && $n <= 1.01) ? $n * 100.0 : $n; };
                    $perModelMetrics[] = [
                        'model' => (string)$modelName,
                        'accuracy' => is_numeric($a) ? round($convert($a), 2) : null,
                        'precision' => is_numeric($p) ? round($convert($p), 2) : null,
                        'recall' => is_numeric($r) ? round($convert($r), 2) : null,
                        'f1' => is_numeric($f) ? round($convert($f), 2) : null,
                    ];
                }
            }

            // If no explicit hybrid model exists, compute a simple hybrid (mean across models)
            $hasHybrid = false;
            foreach ($perModelMetrics as $m) { if (isset($m['model']) && strtolower($m['model']) === 'hybrid') { $hasHybrid = true; break; } }
            if (!$hasHybrid && count($perModelMetrics) > 0) {
                $sum = ['accuracy' => 0.0, 'precision' => 0.0, 'recall' => 0.0, 'f1' => 0.0];
                $cnt = ['accuracy' => 0, 'precision' => 0, 'recall' => 0, 'f1' => 0];
                foreach ($perModelMetrics as $m) {
                    foreach (['accuracy','precision','recall','f1'] as $k) {
                        if (isset($m[$k]) && is_numeric($m[$k])) { $sum[$k] += floatval($m[$k]); $cnt[$k]++; }
                    }
                }
                $hybrid = ['model' => 'hybrid'];
                $any = false;
                foreach (['accuracy','precision','recall','f1'] as $k) {
                    if ($cnt[$k] > 0) { $hybrid[$k] = round($sum[$k] / $cnt[$k], 2); $any = true; } else { $hybrid[$k] = null; }
                }
                if ($any) {
                    // prepend hybrid so it appears first
                    array_unshift($perModelMetrics, $hybrid);
                }
            }

            // Compute a context-aware metric if not present: weighted blend of known models
            $hasContext = false;
            foreach ($perModelMetrics as $m) { if (isset($m['model']) && strtolower($m['model']) === 'context_aware') { $hasContext = true; break; } }
            if (!$hasContext && count($perModelMetrics) > 0) {
                // default weights (adjustable): favor collaborative signals slightly
                $weightsMap = [
                    'content_based' => 0.3,
                    'user_cf' => 0.4,
                    'item_cf' => 0.3,
                ];
                $sumMetrics = ['accuracy' => 0.0, 'precision' => 0.0, 'recall' => 0.0, 'f1' => 0.0];
                $sumWeights = ['accuracy' => 0.0, 'precision' => 0.0, 'recall' => 0.0, 'f1' => 0.0];
                foreach ($perModelMetrics as $m) {
                    $modelKey = strtolower($m['model'] ?? '');
                    $w = $weightsMap[$modelKey] ?? 0.0;
                    foreach (['accuracy','precision','recall','f1'] as $k) {
                        if ($w > 0 && isset($m[$k]) && is_numeric($m[$k])) { $sumMetrics[$k] += floatval($m[$k]) * $w; $sumWeights[$k] += $w; }
                    }
                }
                $ctx = ['model' => 'context_aware'];
                $anyCtx = false;
                foreach (['accuracy','precision','recall','f1'] as $k) {
                    if ($sumWeights[$k] > 0) { $ctx[$k] = round($sumMetrics[$k] / $sumWeights[$k], 2); $anyCtx = true; } else { $ctx[$k] = null; }
                }
                if ($anyCtx) {
                    // put context-aware first so it's visible
                    array_unshift($perModelMetrics, $ctx);
                }
            }
            // If counts are provided, compute metrics: accept many variants for keys
            $getCount = function($keys) use ($eval) {
                foreach ((array)$keys as $k) {
                    if (isset($eval[$k]) && is_numeric($eval[$k])) return floatval($eval[$k]);
                }
                // nested counts object
                if (isset($eval['counts']) && is_array($eval['counts'])) {
                    foreach ((array)$keys as $k) if (isset($eval['counts'][$k]) && is_numeric($eval['counts'][$k])) return floatval($eval['counts'][$k]);
                }
                return null;
            };

            $tp = $getCount(['tp','TP','true_positive','truePositives','true_positive_count']);
            $tn = $getCount(['tn','TN','true_negative','trueNegatives','true_negative_count']);
            $fp = $getCount(['fp','FP','false_positive','falsePositives','false_positive_count']);
            $fn = $getCount(['fn','FN','false_negative','falseNegatives','false_negative_count']);

            if (($metrics['precision'] === null || $metrics['recall'] === null || $metrics['f1'] === null || $metrics['accuracy'] === null) && ($tp !== null || $tn !== null || $fp !== null || $fn !== null)) {
                // compute where possible
                if ($tp !== null && $fp !== null) {
                    $metrics['precision'] = ($tp + $fp) > 0 ? ($tp / ($tp + $fp)) : 0.0;
                }
                if ($tp !== null && $fn !== null) {
                    $metrics['recall'] = ($tp + $fn) > 0 ? ($tp / ($tp + $fn)) : 0.0;
                }
                if ($metrics['precision'] !== null && $metrics['recall'] !== null) {
                    $p = $metrics['precision'];
                    $r = $metrics['recall'];
                    $metrics['f1'] = ($p + $r) > 0 ? (2 * $p * $r / ($p + $r)) : 0.0;
                }
                if ($tp !== null && $tn !== null && $fp !== null && $fn !== null) {
                    $metrics['accuracy'] = ($tp + $tn) / max(1, ($tp + $tn + $fp + $fn));
                }
            }

            // Convert to percentages for display if values look fractional (0-1)
            $display = [];
            foreach (['accuracy','precision','recall','f1'] as $k) {
                $v = $metrics[$k];
                if ($v === null) { $display[$k] = null; continue; }
                if (is_numeric($v)) {
                    $num = floatval($v);
                    if ($num > 0 && $num <= 1.01) $num = $num * 100.0;
                    $display[$k] = round($num, 2);
                } else {
                    $display[$k] = null;
                }
            }
        @endphp

        {{-- @if(!empty($eval) && (array_filter($display) || !empty($perModelMetrics)))
            <div class="mt-4 bg-white p-4 rounded-lg shadow w-full">
                <h4 class="text-gray-800 font-semibold">Evaluation Metrics</h4>
                <p class="text-sm text-gray-600">Displayed below are evaluation results (from <code>public/eval_metrics.json</code>).</p>
                <div class="flex flex-wrap gap-3 mt-3 text-sm">
                    @if(!empty($perModelMetrics))
                        @foreach($perModelMetrics as $m)
                            <div class="px-4 py-2 bg-gray-50 rounded border">
                                <div class="font-semibold text-sm">{{ $m['model'] }}</div>
                                <div class="text-xs text-gray-600 mt-1">
                                    @if($m['accuracy'] !== null)<div><strong>Accuracy:</strong> {{ $m['accuracy'] }}%</div>@endif
                                    @if($m['precision'] !== null)<div><strong>Precision:</strong> {{ $m['precision'] }}%</div>@endif
                                    @if($m['recall'] !== null)<div><strong>Recall:</strong> {{ $m['recall'] }}%</div>@endif
                                    @if($m['f1'] !== null)<div><strong>F1:</strong> {{ $m['f1'] }}%</div>@endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        @if($display['accuracy'] !== null)
                            <div class="px-4 py-2 bg-gray-100 rounded">
                                <strong>Accuracy:</strong> {{ $display['accuracy'] }}% 
                            </div>
                        @endif
                        @if($display['precision'] !== null)
                            <div class="px-4 py-2 bg-gray-100 rounded">
                                <strong>Precision:</strong> {{ $display['precision'] }}% 
                            </div>
                        @endif
                        @if($display['recall'] !== null)
                            <div class="px-4 py-2 bg-gray-100 rounded">
                                <strong>Recall:</strong> {{ $display['recall'] }}% 
                            </div>
                        @endif
                        @if($display['f1'] !== null)
                            <div class="px-4 py-2 bg-gray-100 rounded">
                                <strong>F1 Score:</strong> {{ $display['f1'] }}% 
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif --}}

<section class="max-w-6xl mx-auto mt-10 bg-[#00ae7a] rounded-md p-6">
    <h4 class="text-lg font-semibold text-white flex items-center gap-2">
      💡 Jobs Matched to Your Skills & Preferences
    </h4>
    <p class="text-sm italic text-white">(Ang mga trabahong ito ay tumutugma sa iyong kakayahan at kagustuhan)</p>

    <div class="mt-4">
      <button class="bg-white text-[#00ae7a] font-medium px-6 py-2 rounded-md">All Matches (2)</button>
    </div>
  </section>

  <!-- JOB INFO -->
  <section class="max-w-6xl mx-auto mt-10 px-6">
    <div class="bg-white p-4 border border-gray-300 rounded-md mb-5">
      <p class="text-sm">Click the <a href="#" class="text-[#007BFF] underline">“View Details”</a> button to view more information about the Job.</p>
      <p class="text-xs text-gray-500 italic">(Pindutin ang button na “View Details” para makita ang karagdagang impormasyon...)</p>
    </div>

    <div class="bg-white p-4 border border-gray-300 rounded-md mb-8">
    <a href="{{ route('my.job.applications') }}" class="text-[#007BFF] font-medium underline">Saved Jobs</a>
      <p class="text-sm">Click the “Save” button on any job listing to keep it for later.</p>
      <p class="text-xs text-gray-500 italic">(I-click ang “Save” button sa anumang job listing upang mai-save ito...)</p>
    </div>
  </section>

  <!-- JOB CARDS -->
  <section class="max-w-6xl mx-auto px-6 space-y-8 mb-20">

    <!-- JOB CARD 1 -->
    <div class="bg-white border border-gray-300 rounded-xl p-6 flex justify-between items-center">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">Pet Care Assistant</h3>
        <p class="text-gray-600">iPet Club</p>
        <p class="text-sm text-gray-500 mb-2">Taguig City, Metro Manila</p>
        <div class="flex gap-2 text-xs text-gray-700 mb-3">
          <span class="bg-gray-100 px-3 py-1 rounded-md">Healthcare</span>
          <span class="bg-gray-100 px-3 py-1 rounded-md">Quiet</span>
        </div>
        <p class="text-sm text-gray-700">Help feed animals, clean spaces, and provide companionship.</p>

        <div class="flex gap-2 mt-3 text-xs">
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Organization</span>
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Cleaning</span>
          <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">Following Instructions</span>
        </div>

        <div class="flex gap-2 mt-3 text-xs">
          <span class="bg-[#D1FFD6] text-green-800 px-3 py-1 rounded-md">⭐ Excellent Fit</span>
          <span class="bg-[#E6E9FF] text-[#4F46E5] px-3 py-1 rounded-md">📈 High Potential</span>
        </div>

        <p class="text-xs text-gray-500 mt-3">4d ago</p>
      </div>

      <div class="flex flex-col items-end space-y-3">
        <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" class="w-16 h-16" alt="iPet logo">
        <div class="flex gap-2">
          <button class="bg-[#007BFF] text-white px-4 py-2 rounded-md text-sm">View Details</button>
          <button class="bg-green-600 text-white px-4 py-2 rounded-md text-sm">Saved</button>
        </div>
      </div>
    </div>
    </section>

    <!-- Job Cards -->
    @php
    // defensive fallbacks used by scoring logic to avoid undefined variable errors
    if (!isset($recommendations)) $recommendations = [];
    if (!isset($description)) $description = '';
    if (!isset($skills_desc)) $skills_desc = '';
    if (!isset($hours)) $hours = '';
        // We intentionally only display per-user recommendations (storage/app/reco_user_<safeUid>.json).
        // The server-side preference (above) populated $recommendations when a per-user cache exists.
        // Do NOT fall back to global `public/recommendations.json` or `public/postings.csv` here.
        // If no per-user recommendations were found, $recommendations will remain an empty array and
        // the page will show a friendly message instructing users how to produce per-user recommendations.

        // Load guardian approvals (local storage file) and apply keyword-based filtering (if any filters selected)
        $approvals_path = storage_path('app/guardian_job_approvals.json');
        $guardianApprovals = [];
        if (file_exists($approvals_path)) {
            $guardianApprovals = json_decode(file_get_contents($approvals_path), true) ?: [];
        }


        // Helper: return true if job is approved (string job_id or numeric index)
        $isJobApproved = function($job) use ($guardianApprovals) {
            $id = isset($job['job_id']) ? (string)$job['job_id'] : null;
            if ($id !== null && isset($guardianApprovals[$id]) && isset($guardianApprovals[$id]['status']) && $guardianApprovals[$id]['status'] === 'approved') return true;
            // also check dataIndex style keys if present
            if (isset($job['__dataIndex'])) {
                $di = (string)$job['__dataIndex'];
                if (isset($guardianApprovals[$di]) && isset($guardianApprovals[$di]['status']) && $guardianApprovals[$di]['status'] === 'approved') return true;
            }
            return false;
        };

    // Apply filters (industry via keyword lists, fit_level, growth, work_environment)
    $filtered = [];
    $selectedIndustry = request('industry') ? trim(request('industry')) : '';
        foreach ($recommendations as $job) {
            $show = true;
            if ($selectedIndustry) {
                // If job has an explicit industry string, compare directly; otherwise match against keyword lists
                $jobIndustry = strtolower(trim($job['industry'] ?? ''));
                if ($jobIndustry === strtolower($selectedIndustry)) {
                    // ok
                } else {
                    $kwMatched = false;
                    $needleText = strtolower(($job['job_description'] ?? $job['title'] ?? '') . ' ' . ($job['title'] ?? ''));
                    $kwList = $industryKeywords[$selectedIndustry] ?? [];
                    foreach ($kwList as $kw) { if (strpos($needleText, $kw) !== false) { $kwMatched = true; break; } }
                    if (!$kwMatched) $show = false;
                }
            }
            // location filtering removed per request
            if (request('fit_level') && (!isset($job['fit_level']) || strlen(trim($job['fit_level'])) === 0 || strtolower($job['fit_level']) != strtolower(request('fit_level')))) {
                $show = false;
            }
            if (request('growth_potential') && (!isset($job['growth_potential']) || strlen(trim($job['growth_potential'])) === 0 || strtolower($job['growth_potential']) != strtolower(request('growth_potential')))) {
                $show = false;
            }
            if (request('work_environment') && (!isset($job['work_environment']) || strlen(trim($job['work_environment'])) === 0 || strtolower($job['work_environment']) != strtolower(request('work_environment')))) {
                $show = false;
            }
            if ($show) $filtered[] = $job;
        }

        // Do NOT enforce guardian approval here: show all jobs even if guardian has not approved yet
        // (this keeps the public job list comprehensive). Previously the code filtered out jobs when
        // any guardian approvals existed; we intentionally leave $filtered intact so all jobs appear.

        // Extract unique job titles and companies for a brief summary displayed above the list
        // Use the filtered set so the summary reflects current filters
        $allTitles = [];
        $allCompanies = [];
        foreach ($filtered as $r) {
            $t = trim((string)($r['title'] ?? $r['job_description'] ?? ''));
            $c = trim((string)($r['company'] ?? $r['company_name'] ?? ''));
            if ($t !== '') $allTitles[] = $t;
            if ($c !== '') $allCompanies[] = $c;
        }
        $uniqueTitles = array_values(array_slice(array_unique($allTitles), 0, 200));
        $uniqueCompanies = array_values(array_slice(array_unique($allCompanies), 0, 200));

        // Sort by computed/content/hybrid score if available (normalize all scores to 0-100), else by match_score desc
        // Attempt to load best ensemble weights (produced by tools/optimize_weights.py)
        $bestWeightsPath = public_path('best_weights.json');
        $bestWeights = [];
        if (file_exists($bestWeightsPath)) {
            $bestWeights = json_decode(@file_get_contents($bestWeightsPath), true) ?: [];
        }

        // If best weights present, compute an ensemble_score for each job using mins/maxs stored in bestWeights
        if (!empty($bestWeights) && isset($bestWeights['best']['weights']) && isset($bestWeights['score_columns'])) {
            $bw = $bestWeights['best']['weights'];
            $mins = $bestWeights['mins'] ?? [];
            $maxs = $bestWeights['maxs'] ?? [];
            foreach ($filtered as &$fj) {
                $total = 0.0;
                foreach ($bestWeights['score_columns'] as $col) {
                    // try to find a matching value in the job entry
                    $raw = null;
                    if (isset($fj[$col])) $raw = $fj[$col];
                    elseif (isset($fj[str_replace('_score','',$col)])) $raw = $fj[str_replace('_score','',$col)];
                    elseif (isset($fj['content_score']) && $col === 'content_score') $raw = $fj['content_score'];
                    elseif (isset($fj['computed_score']) && $col === 'computed_score') $raw = $fj['computed_score'];
                    elseif (isset($fj['match_score']) && $col === 'match_score') $raw = $fj['match_score'];
                    $raw = is_numeric($raw) ? floatval($raw) : 0.0;
                    $lo = isset($mins[$col]) ? floatval($mins[$col]) : 0.0;
                    $hi = isset($maxs[$col]) ? floatval($maxs[$col]) : 1.0;
                    $norm = ($hi > $lo) ? (($raw - $lo) / ($hi - $lo)) : 0.0;
                    $w = isset($bw[$col]) ? floatval($bw[$col]) : 0.0;
                    $total += $norm * $w;
                }
                $fj['ensemble_score'] = $total;
            }
            unset($fj);
        }

        usort($filtered, function($a, $b) {
            $getRaw = function($x) {
                // prefer ensemble_score if available
                if (isset($x['ensemble_score']) && $x['ensemble_score'] !== null) return floatval($x['ensemble_score']);
                if (isset($x['content_score']) && $x['content_score'] !== null) return floatval($x['content_score']);
                if (isset($x['computed_score']) && $x['computed_score'] !== null) return floatval($x['computed_score']);
                return floatval($x['match_score'] ?? 0);
            };
            $norm = function($val) {
                // if value looks like 0-1 fraction, scale to 0-100
                if ($val > 0 && $val <= 1.01) return $val * 100.0;
                return $val;
            };
            $aScore = $norm($getRaw($a));
            $bScore = $norm($getRaw($b));
            return $bScore <=> $aScore;
        });

        // Pagination
        $page = max(1, intval(request('page', 1)));
        $perPage = 10;
        $total = count($filtered);
        $recommendations = array_slice($filtered, ($page - 1) * $perPage, $perPage);
        $lastPage = max(1, (int)ceil($total / $perPage));
    @endphp

    <script>
        // Signal to client-side scripts that server rendered per-user recommendations are present
        window.__SERVER_RECO_LOADED = @json(!empty($recommendations) && count($recommendations) > 0);
    </script>

    <div class="max-w-6xl mx-auto px-6 space-y-8 mb-20">
        @if(empty($recommendations))
            <div class="bg-yellow-100 p-6 rounded-xl text-center text-gray-600">
                <p class="mb-3">No personalized job recommendations found for your account.</p>
                <p class="text-sm mb-4">This page displays per-user recommendations only (stored as <code>storage/app/reco_user_{uid}.json</code>).</p>
                @auth
                    <button id="btn-generate-recs" class="bg-blue-500 text-white px-4 py-2 rounded">Generate recommendations now</button>
                    <p id="btn-generate-status" class="text-xs text-gray-600 mt-2"></p>
                @else
                    <p class="text-sm">Please sign in to generate and view your personalized recommendations.</p>
                @endauth
            </div>
        @else
            @foreach($recommendations as $idx => $job)
                @php $job_dom_id = 'job_'.$job['job_id'] ?? ('p'.($page - 1) * $perPage + $idx); @endphp
                @php
                    // raw content/match scores (preserve original for display)
                    $rawContentValue = $job['content_score'] ?? $job['computed_score'] ?? $job['match_score'] ?? 0;
                    $computedMaxScore = $job['computed_max_score'] ?? $job['computed_max'] ?? null;
                    // normalized content score (0-100) for boosting/sorting
                    $normContent = $rawContentValue;
                    if (is_numeric($normContent) && $normContent > 0 && $normContent <= 1.01) $normContent = $normContent * 100.0;
                    $contentAttr = round(floatval($normContent), 2);

                    // Determine a display title: prefer explicit title, then try to extract a short title from job_description
                    // Prefer common title keys (case variants and alternate names) before falling back to description
                    $rawTitle = trim(strval($job['title'] ?? $job['job_title'] ?? $job['Title'] ?? $job['JobTitle'] ?? ''));
                    if ($rawTitle === '') {
                        $desc = trim(strval($job['job_description'] ?? $job['description'] ?? ''));
                        // try to capture a short headline before keywords like 'needed', 'required', ':' or sentence end
                        if (preg_match('/^(.{1,140}?)(?:\.|\n| needed with| needed| required with| required|:| - )/i', $desc, $m)) {
                            $rawTitle = trim($m[1]);
                        } else {
                            // fallback to the first non-empty line of the description (do not arbitrarily truncate job titles)
                            $firstLine = strtok($desc, "\n");
                            $rawTitle = trim($firstLine ?: $desc);
                        }
                    }

                    // company fallback: check multiple fields commonly used in the CSV/JSON
                    $companyName = trim(strval($job['company'] ?? $job['company_name'] ?? $job['Company'] ?? ''));
                    // Show full title (do not truncate) so users see complete job names
                    $titleShort = $rawTitle;
                    // raw match value (preserve original for display). Normalize for percent display
                    $rawMatchVal = $job['match_score'] ?? $job['computed_score'] ?? 0;
                    $matchPercent = 0;
                    $rawMatchDisplay = $rawMatchVal;
                    // if computed_max_score present, include it in raw display for clarity
                    if (!empty($computedMaxScore)) {
                        // show computed_score / computed_max_score format when available
                        if (is_numeric($rawMatchDisplay) && is_numeric($computedMaxScore)) {
                            $rawMatchDisplay = (string)$rawMatchDisplay . ' (max: ' . (string)$computedMaxScore . ')';
                        }
                    }
                    if (is_numeric($rawMatchVal)) {
                        $m = floatval($rawMatchVal);
                        if ($m > 0 && $m <= 1.01) {
                            $matchPercent = round($m * 100);
                            $rawMatchDisplay = $m; // show fractional
                        } elseif ($m > 0 && $m <= 5.0) {
                            // treat 0-5 point scale as out of 5
                            $matchPercent = round($m * 20);
                            $rawMatchDisplay = $m . '/5';
                        } else {
                            $matchPercent = round($m);
                            $rawMatchDisplay = $m;
                        }
                    }
                @endphp
                <div id="{{ $job_dom_id }}" data-job-id="{{ $job['job_id'] ?? (($page - 1) * $perPage + $idx) }}" data-title="{{ e($titleShort) }}" data-company="{{ e($companyName) }}" data-description="{{ e(Str::limit($job['job_description'], 400)) }}" data-location="{{ e($job['location']) }}" data-fit-level="{{ e($job['fit_level'] ?? '') }}" data-content-score="{{ $contentAttr }}" data-raw-content="{{ e($rawContentValue) }}" data-match-percent="{{ $matchPercent }}" data-raw-match="{{ e($rawMatchDisplay) }}" class="job-card bg-white border border-gray-300 rounded-xl p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $titleShort }}</h3>
                        <p class="text-gray-600">{{ $companyName }}</p>
                        <p class="text-sm text-gray-500 mb-2">{{ $job['location'] ?? '' }}</p>
                        <div class="flex gap-2 text-xs text-gray-700 mb-3">
                            @if(!empty($job['industry']))<span class="bg-gray-100 px-3 py-1 rounded-md">{{ $job['industry'] }}</span>@endif
                            @if(!empty($job['work_environment']))<span class="bg-gray-100 px-3 py-1 rounded-md">{{ $job['work_environment'] }}</span>@endif
                        </div>
                        <p class="text-sm text-gray-700">{{ Str::limit($job['job_description'], 220) }}</p>

                        <div class="flex gap-2 mt-3 text-xs">
                            @if(!empty($job['skills_desc']))
                                @php
                                    $skillTags = [];
                                    try { $skillTags = is_string($job['skills_desc']) ? array_filter(array_map('trim', preg_split('/[,;|]+/', $job['skills_desc']))) : []; } catch(
                                        Exception $e) { $skillTags = []; }
                                @endphp
                                @foreach(array_slice($skillTags,0,5) as $st)
                                    <span class="bg-[#C7F9CC] text-[#036666] px-3 py-1 rounded-md">{{ $st }}</span>
                                @endforeach
                            @endif
                        </div>

                        <div class="flex gap-2 mt-3 text-xs">
                            @if($job['fit_level'])<span class="bg-[#D1FFD6] text-green-800 px-3 py-1 rounded-md">⭐ {{ $job['fit_level'] }}</span>@endif
                            @if($job['growth_potential'])<span class="bg-[#E6E9FF] text-[#4F46E5] px-3 py-1 rounded-md">📈 {{ $job['growth_potential'] }}</span>@endif
                        </div>

                        <p class="text-xs text-gray-500 mt-3">@if(isset($job['listed_time'])){{ $job['listed_time'] }}@else{{ ' ' }}@endif</p>
                        <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: {{ $job['job_id'] ?? (($page - 1) * $perPage + $idx) }}</span>
                    </div>

                    <div class="flex flex-col items-end space-y-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" class="w-16 h-16" alt="logo">
                        <div class="flex gap-2">
                            <a href="{{ route('job.details', ['job_id' => $job['job_id'] ?? (($page - 1) * $perPage + $idx)]) }}" class="bg-[#007BFF] text-white px-4 py-2 rounded-md text-sm">View Details</a>
                            <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                @csrf
                                <input type="hidden" name="job_id" value="{{ $job['job_id'] ?? (($page - 1) * $perPage + $idx) }}">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                @if($page > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}" class="px-4 py-2 bg-blue-100 rounded-l hover:bg-blue-200">Previous</a>
                @endif
                <span class="px-4 py-2 bg-white border-t border-b">{{ $page }} / {{ $lastPage }}</span>
                @if($page < $lastPage)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}" class="px-4 py-2 bg-blue-100 rounded-r hover:bg-blue-200">Next</a>
                @endif
            </div>
        @endif
    </div>
</div>
<!-- Ensure user is signed-in before taking actions like Apply or Save -->
<script src="{{ asset('js/firebase-config-global.js') }}"></script>
    <script>
        @auth
            window.__SERVER_AUTH = true;
        @else
            window.__SERVER_AUTH = false;
        @endauth
    </script>
    <script type="module">
    (async function(){
        try {
            const mod = await import("{{ asset('js/job-application-firebase.js') }}");
            const logger = await import("{{ asset('js/client-logger.js') }}");
            // Attempt server-backed sign-in (makes Firebase ID token available to the page)
            try {
                await mod.signInWithServerToken("{{ route('firebase.token') }}");
            } catch(e) { console.debug('job-matches signInWithServerToken failed', e); try { logger.sendClientLog('debug', 'job-matches signInWithServerToken failed', { error: String(e) }); } catch(_) {} }
            const signed = await mod.isSignedIn(7000);
            console.debug('job-matches auth guard: isSignedIn ->', signed);
            if (!signed) {
                if (window.__SERVER_AUTH) {
                    console.info('job-matches: server session present, not redirecting');
                    try { logger.sendClientLog('info', 'job-matches auth guard: server session present', {}); } catch(_) {}
                    return;
                }
                const current = window.location.pathname + window.location.search;
                try { logger.sendClientLog('info', 'job-matches auth guard: redirecting to login', { redirect: current }); } catch(_) {}
                window.location.href = 'login?redirect=' + encodeURIComponent(current);
                return;
            }
        } catch (err) {
            console.error('job-matches auth guard failed', err);
            try { (await import("{{ asset('js/client-logger.js') }}")).sendClientLog('error', 'job-matches auth guard failed', { error: String(err) }); } catch(_) {}
        }
    })();
    
    // If server-side session exists but client Firebase profile is not present,
    // trigger the recommendations generator on the server so users who are
    // authenticated via backend still get per-user recs on page load.
    (async function(){
        try {
            if (!window.__SERVER_AUTH) return; // only when server session present
            // don't spam: set a short guard in sessionStorage per-page-load
            const key = 'reco_auto_trigger_' + window.location.pathname;
            if (sessionStorage.getItem(key)) return;
            sessionStorage.setItem(key, '1');
            window.__HYBRID_RECO_DEBUG = window.__HYBRID_RECO_DEBUG || { events: [] };
            window.__HYBRID_RECO_DEBUG.events.push({ when: Date.now(), ev: 'auto_trigger_via_server_session' });
            const resp = await fetch('{{ url('/api/recommendations/user') }}', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                // request a forced synchronous generation when possible (dev-friendly)
                body: JSON.stringify({ force: true })
            });
            window.__HYBRID_RECO_DEBUG.events.push({ when: Date.now(), ev: 'auto_trigger_response', status: resp.status });
        } catch (e) {
            console.debug('auto server-side reco trigger failed', e);
        }
    })();
    @if(app()->environment('local') || request()->getHost() === 'localhost')
    // In local environment, also trigger a bulk generation for all users so per-UID caches are created.
    (async function(){
        try {
            // Run bulk generation (restricted to local by server route). Do not block UI.
            fetch('{{ url('/api/recommendations/all') }}', { method: 'POST', credentials: 'same-origin', headers: {'Content-Type':'application/json'}, body: JSON.stringify({}) }).then(r => r.json()).then(j => console.debug('bulk reco all triggered', j)).catch(e=>console.debug('bulk reco all failed', e));
        } catch (e) { console.debug('bulk reco all start failed', e); }
    })();
    @endif
    </script>
    <script>
        // Hook up the "Generate recommendations now" button to call the per-user API
        document.addEventListener('DOMContentLoaded', function(){
            const btn = document.getElementById('btn-generate-recs');
            const status = document.getElementById('btn-generate-status');
            if (!btn) return;
            btn.addEventListener('click', async function(){
                if (window.__SERVER_RECO_LOADED) {
                    status.textContent = 'Server-rendered recommendations already present; reload page to refresh.';
                    btn.disabled = false;
                    return;
                }
                try {
                    btn.disabled = true;
                    status.textContent = 'Requesting generation...';
                    const r = await fetch('{{ url('/api/recommendations/user') }}', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ force: true })
                    });
                    if (r.status === 202) {
                        status.textContent = 'Generation scheduled; please refresh this page in a few seconds.';
                    } else if (r.ok) {
                        // Try to parse returned recommendations and render them in-place instead of reloading
                        const data = await r.json().catch(()=>null);
                        const normalize = (d) => {
                            if (!d) return [];
                            if (Array.isArray(d)) return d;
                            if (typeof d === 'object') {
                                const vals = Object.values(d);
                                const arrVal = vals.find(v => Array.isArray(v));
                                if (arrVal) return arrVal;
                                const keys = Object.keys(d || {});
                                if (keys.length > 0 && Array.isArray(d[keys[0]])) return d[keys[0]];
                            }
                            return [];
                        };
                        const recs = normalize(data);
                        if (recs && recs.length > 0) {
                            status.textContent = 'Recommendations generated — rendering results.';
                            // lightweight escape to avoid XSS from returned payload
                            const esc = s => { if (s === null || s === undefined) return ''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); };
                            const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
                            if (container) {
                                let out = '';
                                recs.slice(0,50).forEach((r2, idx) => {
                                    const jid = String(r2.job_id ?? ('p' + idx));
                                    const title = esc(r2.Title || r2.title || r2.job_title || (r2.job_description || '').substring(0,80) || 'Untitled Job');
                                    const company = esc(r2.Company || r2.company || r2.company_name || '');
                                    let rawMatchVal = Number(r2.hybrid_score ?? r2.content_score ?? r2.match_score ?? 0) || 0;
                                    let matchPercent = 0;
                                    if (rawMatchVal > 0 && rawMatchVal <= 1.01) matchPercent = Math.round(rawMatchVal * 100);
                                    else if (rawMatchVal > 0 && rawMatchVal <= 5.0) matchPercent = Math.round(rawMatchVal * 20);
                                    else matchPercent = Math.round(rawMatchVal);
                                    const why = esc((r2.job_description || r2.description || '').substring(0,400));
                                    const industry = esc(r2.industry || '');
                                    const workEnv = esc(r2.work_environment || '');
                                    const fit = esc(r2.fit_level || '');
                                    const growth = esc(r2.growth_potential || '');
                                    const salary = esc(r2.salary ?? '-');
                                    const deadline = esc(r2.deadline ?? '');
                                    out += `
                                        <div id="job_${jid}" data-job-id="${jid}" data-job-id-canonical="${jid}" data-title="${title}" data-company="${company}" data-description="${why}" data-location="${esc(r2.location || '')}" data-fit-level="${fit}" data-content-score="${esc(String(r2.content_score ?? r2.computed_score ?? 0))}" data-raw-match="${esc(String(rawMatchVal))}" class="job-card bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start">
                                            <div class="flex-1 pr-6">
                                                <h3 class="text-lg font-bold">${title}</h3>
                                                <div class="mt-2"><span class="js-match-badge bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">${matchPercent}% Match <small class="text-xs text-gray-500">(raw: ${esc(String(rawMatchVal))})</small></span></div>
                                                ${ company ? `<p class="text-sm text-gray-700 font-medium">${company}</p>` : '' }
                                                <p class="text-gray-600 mt-2 text-sm">${why}</p>
                                                <div class="flex gap-2 text-xs mt-2">
                                                    ${ industry ? `<span class="bg-gray-100 px-2 py-1 rounded">${industry}</span>` : '' }
                                                    ${ workEnv ? `<span class="bg-gray-100 px-2 py-1 rounded">${workEnv}</span>` : '' }
                                                </div>
                                                <div class="flex gap-2 mt-2">
                                                    ${ fit ? `<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">${fit}</span>` : '' }
                                                    ${ growth ? `<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">${growth}</span>` : '' }
                                                </div>
                                                <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: ${jid}</span>
                                                <p class="text-xs text-gray-400 mt-1">Salary: ${salary} ${ deadline ? '• Deadline: ' + deadline : '' }</p>
                                            </div>
                                            <div class="flex items-center gap-3 mt-4 md:mt-0">
                                                <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 text-center text-sm font-medium leading-none">View Details</a>
                                                <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="job_id" value="${jid}">
                                                    <button type="submit" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-green-600 text-white px-4 rounded-lg hover:bg-green-700 text-sm font-medium leading-none">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    `;
                                });
                                container.innerHTML = out;
                            }
                        } else {
                            // If no recs returned, fall back to reload so server-side may pick up any new cache
                            status.textContent = 'Generated but no recommendations returned; reloading...';
                            setTimeout(() => location.reload(), 800);
                        }
                    } else {
                        const j = await r.json().catch(()=>({}));
                        status.textContent = 'Generation failed: ' + (j.message || r.statusText || 'unknown');
                    }
                } catch (e) {
                    status.textContent = 'Generation error: ' + String(e);
                } finally { btn.disabled = false; }
            });
        });
    </script>
    <script>
        // expose guardian approvals to client-side renderer
        window.__GUARDIAN_APPROVALS = {!! json_encode($guardianApprovals ?? []) !!};
        function escapeHtml(s) { if (!s) return ''; return String(s).replace(/[&<>"]+/g, function(ch){ return {'&':'&amp;','<':'&lt;','>':'&gt;', '"':'&quot;'}[ch]; }); }
    </script>
    <script type="module">
        // Load the lightweight per-user rescoring helper that uses the signed-in Firebase profile
        try {
            await import("{{ asset('js/job-rescore-client.js') }}");
        } catch (e) {
            console.debug('failed to load job-rescore-client', e);
        }
    </script>
    <script type="module">
    (async function(){
        try {
            const mod = await import("{{ asset('js/job-application-firebase.js') }}");
            console.debug('Auth guard: waiting for sign-in resolution (7s)');
            try {
                await mod.signInWithServerToken("{{ route('firebase.token') }}");
            } catch (e) { console.debug('signInWithServerToken failed', e); }
            const signed = await mod.isSignedIn(7000);
            console.debug('Auth guard: isSignedIn ->', signed);
            try {
                if (mod && typeof mod.debugAuthLogging === 'function') {
                    // start auth state logging (returns unsubscribe function)
                    window.__unsubAuthLog = mod.debugAuthLogging();
                }
            } catch (e) {
                console.warn('debugAuthLogging invocation failed', e);
            }
            if (!signed) {
                // if server has a session, assume the user is already authenticated via backend and skip client redirect
                if (window.__SERVER_AUTH) {
                    console.info('Auth guard: server session present, not redirecting');
                    return;
                }
                // if still not signed after waiting, redirect to login
                const current = window.location.pathname + window.location.search;
                console.info('Auth guard: not signed, redirecting to login');
                window.location.href = 'login?redirect=' + encodeURIComponent(current);
                return;
            }
        } catch (err) {
            console.error('Auth guard failed on job matches', err);
        }
    })();

    // Guardian approve/flag handlers (AJAX) - require authentication
    function postAction(url, body) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(body || {})
        }).then(r => r.json());
    }

    // Approve/flag actions are only available in the Guardian Review pages; no handlers here.
</script>
<script type="module">
// Re-score job cards using the user's Firestore profile (if available)
(async function(){
    try {
        const mod = await import("{{ asset('js/job-application-firebase.js') }}");
        await mod.ensureInit?.();
        // Ensure server-backed sign-in so getUserProfile can access Firestore document
        let profile = null;
        try {
            try { await mod.signInWithServerToken("{{ route('firebase.token') }}"); } catch(e) { console.debug('signInWithServerToken (rescore) failed', e); }
            profile = await mod.getUserProfile();
        } catch(e) { console.debug('no profile from firebase module', e); }

        if (!profile) return;
        // Normalize profile fields
        const jobPrefs = [];
        try {
            const jp1 = profile.jobPreferences?.jobpref1 || profile.jobPreferences?.jobpref_1 || profile.jobpref1;
            const jp2 = profile.jobPreferences?.jobpref2 || profile.jobpref2;
            if (jp1) JSON.parse(jp1).forEach(x=>jobPrefs.push(String(x).toLowerCase()));
            if (jp2) JSON.parse(jp2).forEach(x=>jobPrefs.push(String(x).toLowerCase()));
        } catch(e) { /* ignore parse */ }
        const skills = [];
        try { if (profile.skills?.skills_page1) JSON.parse(profile.skills.skills_page1).forEach(x=>skills.push(String(x).toLowerCase())); } catch(e) {}
        try { if (profile.skills?.skills_page2) JSON.parse(profile.skills.skills_page2).forEach(x=>skills.push(String(x).toLowerCase())); } catch(e) {}
        const workplace = (profile.workplace?.workplace_choice || '').toLowerCase();
        const support = (profile.supportNeed?.support_choice || '').toLowerCase();

        // iterate job cards and compute new score, store numeric value on element for sorting
        const scored = [];
                document.querySelectorAll('.job-card').forEach(card => {
            try {
                const title = (card.dataset.title || '').toLowerCase();
                const desc = (card.dataset.description || '').toLowerCase();
                // server-provided content score (0-100) if available
                        const serverContent = parseFloat(card.dataset.contentScore || card.dataset.contentscore || '0') || 0;
                        // fallback: use data-match-percent or visible badge base
                        const datasetMatchPct = parseInt(card.dataset.matchPercent || card.dataset.matchpercent || '0') || 0;
                        let base = serverContent || datasetMatchPct || (parseInt(card.querySelector('.js-match-badge')?.textContent || '0') || 0);
                // compute boosts from user profile
                let boost = 0;
                jobPrefs.forEach(p => { if (!p) return; const pp = String(p).toLowerCase(); if (title.includes(pp) || desc.includes(pp)) boost += 20; });
                skills.forEach(s => { if (!s) return; const ss = String(s).toLowerCase(); if (title.includes(ss) || desc.includes(ss)) boost += 10; });
                if (workplace && desc.includes(workplace)) boost += 12;
                if (support && desc.includes(support)) boost += 6;
                const final = Math.min(100, Math.max(0, Math.round(base + boost)));
                const badge = card.querySelector('.js-match-badge');
                // Preserve raw display if present, and include computed max if provided
                const rawMatch = card.dataset.rawMatch || card.getAttribute('data-raw-match') || card.dataset.rawmatch || '';
                const computedScore = card.dataset.computedScore || card.getAttribute('data-computed-score') || '';
                const computedMax = card.dataset.computedMax || card.getAttribute('data-computed-max') || '';
                let rawDisplayText = '';
                if (rawMatch) rawDisplayText = ` (raw: ${rawMatch})`;
                if (!rawDisplayText && computedScore) rawDisplayText = ` (computed: ${computedScore}${computedMax ? ' / ' + computedMax : ''})`;
                if (badge) badge.innerHTML = final + '% Match' + '<small class="text-xs text-gray-500">' + rawDisplayText + '</small>';
                card.dataset.personalScore = String(final);
                scored.push({ card, score: final });
            } catch(e) { console.error('rescore error', e); }
        });

        // Reorder DOM: place job cards in descending order of personal score
        if (scored.length > 1) {
            const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
            if (container) {
                // sort scored array
                scored.sort((a,b) => b.score - a.score);
                // remove existing nodes and re-append in order
                scored.forEach(s => {
                    container.appendChild(s.card);
                });
            }
        }

        // Also request server-side hybrid recommendations (collaborative + content)
        try {
            // If server already rendered per-user recommendations, skip client-side hybrid replacement
            if (window.__SERVER_RECO_LOADED) {
                console.debug('job-matches: server-rendered per-user recommendations present; skipping client hybrid replacement');
                return;
            }
            // Global debug for hybrid recommender
            window.__HYBRID_RECO_DEBUG = window.__HYBRID_RECO_DEBUG || { events: [], lastRecs: null };
            function hdbg(ev, payload) { try { window.__HYBRID_RECO_DEBUG.events.push({ when: Date.now(), ev, payload }); } catch(e){}; try { console.debug('hybrid-reco:', ev, payload); } catch(e){} }
            hdbg('request_start', { url: '{{ url('/api/recommendations/user') }}', uid: profile.uid || profile.userId || profile.user_id || '' });
            const resp = await fetch('{{ url('/api/recommendations/user') }}', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                // ask server to force generation/sync when possible for immediate results
                body: JSON.stringify(Object.assign({ uid: profile.uid || profile.userId || profile.user_id || '', force: true }, profile))
            });
            hdbg('request_done', { status: resp.status, statusText: resp.statusText });
            // helper: normalize server response into an array of recommendation objects
            async function normalizeRecsFromResponse(response) {
                const data = await response.json();
                hdbg('normalize_response_raw', { sample: (Array.isArray(data) ? data.slice(0,5) : Object.keys(data || {}).slice(0,10)) });
                if (Array.isArray(data)) return data;
                if (data && typeof data === 'object') {
                    const vals = Object.values(data);
                    const arrVal = vals.find(v => Array.isArray(v));
                    if (arrVal) return arrVal;
                    const keys = Object.keys(data || {});
                    if (keys.length > 0 && Array.isArray(data[keys[0]])) return data[keys[0]];
                }
                return [];
            }

            if (resp.status === 202) {
                console.info('Hybrid recommender scheduled; polling for results...');
                hdbg('scheduled_polling_start', { maxAttempts: 10, delayMs: 3000 });
                // Poll a few times for generated recommendations
                const maxAttempts = 10;
                const delayMs = 3000;
                let attempts = 0;
                let recs = [];
                while (attempts < maxAttempts) {
                    attempts++;
                    await new Promise(r => setTimeout(r, delayMs));
                    try {
                        hdbg('poll_attempt', { attempt: attempts });
                        const pollResp = await fetch('{{ url('/api/recommendations/user') }}', {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(Object.assign({ uid: profile.uid || profile.userId || profile.user_id || '' }, profile))
                            });
                        hdbg('poll_response', { attempt: attempts, status: pollResp.status });
                        if (pollResp.ok) {
                            recs = await normalizeRecsFromResponse(pollResp);
                            hdbg('poll_got_recs', { attempt: attempts, recCount: recs.length });
                            break;
                        }
                    } catch (e) {
                        hdbg('poll_error', { attempt: attempts, error: String(e) });
                        console.debug('Poll attempt failed', e);
                    }
                }
                if (recs.length === 0) {
                    hdbg('no_recs_after_polling');
                    console.warn('No recommendations received after polling.');
                } else {
                    hdbg('got_recs', { recCount: recs.length });
                    window.__HYBRID_RECO_DEBUG.lastRecs = recs;
                    // If the server returned a fresh recommendation set, rebuild the job list
                    (function renderRecs(recsArr){
                        try {
                            const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
                            if (!container) return;
                            // Build new HTML: header + cards
                            let out = '';
                            // Render up to 50 recommendations to avoid overly long pages
                            recsArr.slice(0,50).forEach((r, idx) => {
                                const jid = String(r.job_id ?? ('p' + idx));
                                const title = escapeHtml(String(r.Title || r.title || r.job_title || r.job_description || 'Untitled Job'));
                                const company = escapeHtml(String(r.Company || r.company || r.company_name || ''));
                                let rawMatchVal = Number(r.hybrid_score ?? r.content_score ?? r.match_score ?? 0) || 0;
                                let matchPercent = 0;
                                if (rawMatchVal > 0 && rawMatchVal <= 1.01) matchPercent = Math.round(rawMatchVal * 100);
                                else if (rawMatchVal > 0 && rawMatchVal <= 5.0) matchPercent = Math.round(rawMatchVal * 20);
                                else matchPercent = Math.round(rawMatchVal);
                                const why = escapeHtml(String((r.job_description || r.description || '').substring(0,400)));
                                const industry = escapeHtml(String(r.industry || ''));
                                const workEnv = escapeHtml(String(r.work_environment || ''));
                                const fit = escapeHtml(String(r.fit_level || ''));
                                const growth = escapeHtml(String(r.growth_potential || ''));
                                const salary = escapeHtml(String(r.salary ?? '-'));
                                const deadline = escapeHtml(String(r.deadline ?? ''));
                                out += `
                                    <div id="job_${jid}" data-job-id="${jid}" data-job-id-canonical="${jid}" data-title="${title}" data-company="${company}" data-description="${why}" data-location="${escapeHtml(String(r.location || ''))}" data-fit-level="${fit}" data-content-score="${escapeHtml(String(r.content_score ?? r.computed_score ?? 0))}" data-raw-match="${escapeHtml(String(rawMatchVal))}" class="job-card bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start">
                                        <div class="flex-1 pr-6">
                                            <h3 class="text-lg font-bold">${title}</h3>
                                            <div class="mt-2"><span class="js-match-badge bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">${matchPercent}% Match <small class="text-xs text-gray-500">(raw: ${escapeHtml(String(rawMatchVal))})</small></span></div>
                                            ${ company ? `<p class="text-sm text-gray-700 font-medium">${company}</p>` : '' }
                                            <p class="text-gray-600 mt-2 text-sm">${why}</p>
                                            <div class="flex gap-2 text-xs mt-2">
                                                ${ industry ? `<span class="bg-gray-100 px-2 py-1 rounded">${industry}</span>` : '' }
                                                ${ workEnv ? `<span class="bg-gray-100 px-2 py-1 rounded">${workEnv}</span>` : '' }
                                            </div>
                                            <div class="flex gap-2 mt-2">
                                                ${ fit ? `<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">${fit}</span>` : '' }
                                                ${ growth ? `<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">${growth}</span>` : '' }
                                            </div>
                                            <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: ${jid}</span>
                                            <p class="text-xs text-gray-400 mt-1">Salary: ${salary} ${ deadline ? '• Deadline: ' + deadline : '' }</p>
                                        </div>
                                        <div class="flex items-center gap-3 mt-4 md:mt-0">
                                            <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 text-center text-sm font-medium leading-none">View Details</a>
                                            <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="job_id" value="${jid}">
                                                <button type="submit" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-green-600 text-white px-4 rounded-lg hover:bg-green-700 text-sm font-medium leading-none">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                `;
                            });
                            container.innerHTML = out;
                        } catch(e) { console.error('renderRecs error', e); }
                    })(recs);
                }
            } else if (resp.ok) {
                const recs = await normalizeRecsFromResponse(resp);
                hdbg('immediate_recs', { count: recs.length });
                window.__HYBRID_RECO_DEBUG.lastRecs = recs;
                // Rebuild the job list from fresh recommendations so stale server-rendered list is replaced
                (function renderRecsImmediate(recsArr){
                    try {
                        const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
                        if (!container) return;
                        let out = '';
                        recsArr.slice(0,50).forEach((r, idx) => {
                            const jid = String(r.job_id ?? ('p' + idx));
                            const title = escapeHtml(String(r.Title || r.title || r.job_title || r.job_description || 'Untitled Job'));
                            const company = escapeHtml(String(r.Company || r.company || r.company_name || ''));
                            let rawMatchVal = Number(r.hybrid_score ?? r.content_score ?? r.match_score ?? 0) || 0;
                            let matchPercent = 0;
                            if (rawMatchVal > 0 && rawMatchVal <= 1.01) matchPercent = Math.round(rawMatchVal * 100);
                            else if (rawMatchVal > 0 && rawMatchVal <= 5.0) matchPercent = Math.round(rawMatchVal * 20);
                            else matchPercent = Math.round(rawMatchVal);
                            const why = escapeHtml(String((r.job_description || r.description || '').substring(0,400)));
                            const industry = escapeHtml(String(r.industry || ''));
                            const workEnv = escapeHtml(String(r.work_environment || ''));
                            const fit = escapeHtml(String(r.fit_level || ''));
                            const growth = escapeHtml(String(r.growth_potential || ''));
                            const salary = escapeHtml(String(r.salary ?? '-'));
                            const deadline = escapeHtml(String(r.deadline ?? ''));
                            out += `
                                <div id="job_${jid}" data-job-id="${jid}" data-job-id-canonical="${jid}" data-title="${title}" data-company="${company}" data-description="${why}" data-location="${escapeHtml(String(r.location || ''))}" data-fit-level="${fit}" data-content-score="${escapeHtml(String(r.content_score ?? r.computed_score ?? 0))}" data-raw-match="${escapeHtml(String(rawMatchVal))}" class="job-card bg-white border border-gray-300 rounded-xl p-6 flex justify-between items-center">
                                                        <div>
                                                            <h3 class="text-lg font-semibold text-gray-800">${title}</h3>
                                                            ${ company ? `<p class="text-gray-600">${company}</p>` : '' }
                                                            <p class="text-sm text-gray-500 mb-2">${escapeHtml(String(r.location || ''))}</p>
                                                            <div class="flex gap-2 text-xs text-gray-700 mb-3">
                                                                ${ industry ? `<span class="bg-gray-100 px-3 py-1 rounded-md">${industry}</span>` : '' }
                                                                ${ workEnv ? `<span class="bg-gray-100 px-3 py-1 rounded-md">${workEnv}</span>` : '' }
                                                            </div>
                                                            <p class="text-sm text-gray-700">${why}</p>
                                                            <div class="flex gap-2 mt-3 text-xs">
                                                                ${ fit ? `<span class="bg-[#D1FFD6] text-green-800 px-3 py-1 rounded-md">⭐ ${fit}</span>` : '' }
                                                                ${ growth ? `<span class="bg-[#E6E9FF] text-[#4F46E5] px-3 py-1 rounded-md">📈 ${growth}</span>` : '' }
                                                            </div>
                                                            <p class="text-xs text-gray-500 mt-3">${ deadline ? '• Deadline: ' + deadline : '' }</p>
                                                        </div>
                                                        <div class="flex flex-col items-end space-y-3">
                                                            <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" class="w-16 h-16" alt="logo">
                                                            <div class="flex gap-2">
                                                                <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="bg-[#007BFF] text-white px-4 py-2 rounded-md text-sm">View Details</a>
                                                                <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="hidden" name="job_id" value="${jid}">
                                                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm">Save</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: ${jid}</span>
                                                    </div>
                            `;
                        });
                        container.innerHTML = out;
                    } catch(e) { console.error('renderRecsImmediate error', e); }
                })(recs);
            } else {
                hdbg('request_error', { status: resp.status });
                console.warn('Hybrid recommender error', resp.status);
            }
        } catch(e) {
            hdbg('request_exception', { error: String(e) });
            console.debug('Hybrid recommender failed', e);
        }
    } catch(err) { console.debug('rescore aborted', err); }
})();

// Poll the hybrid recommender periodically so the job list stays up-to-date.
(function(){
    try {
        // small helper to avoid XSS when injecting server-provided fields
        const escapeHtml = (str) => {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        };
        const pollIntervalMs = 20000; // 20s
        let lastHash = null;
        async function pollOnce() {
            if (window.__SERVER_RECO_LOADED) {
                // Avoid replacing server-rendered per-user results
                console.debug('job-matches: server-rendered per-user recommendations present; skipping poll replace');
                return;
            }
            try {
                // attempt to read client profile if available
                let profile = null;
                try {
                    const mod = await import("{{ asset('js/job-application-firebase.js') }}");
                    if (mod && typeof mod.getUserProfile === 'function') profile = await mod.getUserProfile();
                } catch(e) { /* ignore */ }
                const body = profile ? Object.assign({ uid: profile.uid || profile.userId || profile.user_id || '' }, profile) : {};
                const resp = await fetch('{{ url('/api/recommendations/user') }}', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(Object.assign(body, { force: false }))
                });
                if (!resp.ok && resp.status !== 202) return;
                const json = await resp.json().catch(()=>null);
                if (!json) return;
                // normalize to array
                let recs = [];
                if (Array.isArray(json)) recs = json;
                else if (json && typeof json === 'object') {
                    const vals = Object.values(json).filter(v => Array.isArray(v));
                    if (vals.length > 0) recs = vals[0];
                    else recs = Object.keys(json).map(k => json[k]);
                }
                const hash = JSON.stringify(recs.slice(0,50));
                if (hash !== lastHash) {
                    lastHash = hash;
                    try { window.__HYBRID_RECO_DEBUG = window.__HYBRID_RECO_DEBUG || {}; window.__HYBRID_RECO_DEBUG.lastRecs = recs; } catch(e){}
                    // rebuild DOM similar to server-render replacement
                    try {
                        const container = document.querySelector('.container.mx-auto.mt-8.px-4.space-y-6');
                        if (!container) return;
                        let out = '';
                        recs.slice(0,50).forEach((r, idx) => {
                            const jid = String(r.job_id ?? ('p' + idx));
                            const title = escapeHtml(String(r.Title || r.title || r.job_title || r.job_description || 'Untitled Job'));
                            const company = escapeHtml(String(r.Company || r.company || r.company_name || ''));
                            let rawMatchVal = Number(r.hybrid_score ?? r.content_score ?? r.match_score ?? 0) || 0;
                            let matchPercent = 0;
                            if (rawMatchVal > 0 && rawMatchVal <= 1.01) matchPercent = Math.round(rawMatchVal * 100);
                            else if (rawMatchVal > 0 && rawMatchVal <= 5.0) matchPercent = Math.round(rawMatchVal * 20);
                            else matchPercent = Math.round(rawMatchVal);
                            const why = escapeHtml(String((r.job_description || r.description || '').substring(0,400)));
                            const industry = escapeHtml(String(r.industry || ''));
                            const workEnv = escapeHtml(String(r.work_environment || ''));
                            const fit = escapeHtml(String(r.fit_level || ''));
                            const growth = escapeHtml(String(r.growth_potential || ''));
                            const salary = escapeHtml(String(r.salary ?? '-'));
                            const deadline = escapeHtml(String(r.deadline ?? ''));
                            out += `
                                <div id="job_${jid}" data-job-id="${jid}" data-job-id-canonical="${jid}" data-title="${title}" data-company="${company}" data-description="${why}" data-location="${escapeHtml(String(r.location || ''))}" data-fit-level="${fit}" data-content-score="${escapeHtml(String(r.content_score ?? r.computed_score ?? 0))}" data-raw-match="${escapeHtml(String(rawMatchVal))}" class="job-card bg-white shadow-md rounded-xl p-6 flex flex-col md:flex-row justify-between items-start">
                                    <div class="flex-1 pr-6">
                                        <h3 class="text-lg font-bold">${title}</h3>
                                        <div class="mt-2"><span class="js-match-badge bg-green-100 text-green-800 px-3 py-1 rounded-md text-sm font-semibold">${matchPercent}% Match <small class="text-xs text-gray-500">(raw: ${escapeHtml(String(rawMatchVal))})</small></span></div>
                                        ${ company ? `<p class="text-sm text-gray-700 font-medium">${company}</p>` : '' }
                                        <p class="text-gray-600 mt-2 text-sm">${why}</p>
                                        <div class="flex gap-2 text-xs mt-2">
                                            ${ industry ? `<span class="bg-gray-100 px-2 py-1 rounded">${industry}</span>` : '' }
                                            ${ workEnv ? `<span class="bg-gray-100 px-2 py-1 rounded">${workEnv}</span>` : '' }
                                        </div>
                                        <div class="flex gap-2 mt-2">
                                            ${ fit ? `<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">${fit}</span>` : '' }
                                            ${ growth ? `<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">${growth}</span>` : '' }
                                        </div>
                                        <span class="job-id-debug" style="display:block;font-size:10px;color:#666;margin-top:4px">debug-id: ${jid}</span>
                                        <p class="text-xs text-gray-400 mt-1">Salary: ${salary} ${ deadline ? '• Deadline: ' + deadline : '' }</p>
                                    </div>
                                    <div class="flex items-center gap-3 mt-4 md:mt-0">
                                            <a href="/job-details?job_id=${encodeURIComponent(jid)}" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 text-center text-sm font-medium leading-none">View Details</a>
                                            <form method="POST" action="{{ route('my.job.applications') }}" class="inline-block">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="job_id" value="${jid}">
                                                <button type="submit" class="inline-flex items-center justify-center h-11 min-w-[120px] bg-green-600 text-white px-4 rounded-lg hover:bg-green-700 text-sm font-medium leading-none">Save</button>
                                            </form>
                                    </div>
                                </div>
                            `;
                        });
                        container.innerHTML = out;
                    } catch(e) { console.error('rebuild DOM error', e); }
                }
            } catch (e) { console.debug('pollOnce error', e); }
        }
        pollOnce();
        setInterval(pollOnce, pollIntervalMs);
    } catch (e) { console.debug('polling setup failed', e); }
})();
</script>
@endsection
