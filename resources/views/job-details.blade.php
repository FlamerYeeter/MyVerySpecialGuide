@extends('layouts.includes')

@section('content')

    <!-- Icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    @php
        $csv_path = public_path('postings.csv');
        $job = null;
        $job_id = request('job_id');

        // First prefer precomputed recommendations.json if present (job-matches may be using it)
        $json_path = public_path('recommendations.json');
        if ($job_id !== null && file_exists($json_path)) {
            $rows = json_decode(@file_get_contents($json_path), true) ?: [];
            // Try to find by explicit job_id field (string/int) or by array index
            foreach ($rows as $idx => $r) {
                if (isset($r['job_id']) && (string) $r['job_id'] === (string) $job_id) {
                    $job = [
                        'title' =>
                            trim($r['Title'] ?? ($r['title'] ?? '')) ?:
                            (strlen(trim($r['job_description'] ?? ''))
                                ? Str::limit($r['job_description'], 80)
                                : 'Untitled Job'),
                        'company' => trim($r['Company'] ?? ($r['company'] ?? '')),
                        'job_description' => $r['job_description'] ?? ($r['description'] ?? ''),
                        'job_requirement' => $r['resume'] ?? ($r['job_requirement'] ?? ''),
                        'location' => $r['location'] ?? '',
                        'hours' => $r['formatted_work_type'] ?? ($r['hours'] ?? ''),
                        'salary' => $r['salary'] ?? ($r['Salary'] ?? null),
                        'start_date' => $r['original_listed_time'] ?? null,
                        'deadline' => $r['deadline'] ?? null,
                        'announcement_code' => $r['announcement_code'] ?? '',
                        'job_posting_url' => $r['job_posting_url'] ?? '',
                        'application_url' => $r['application_url'] ?? '',
                        'fit_level' => $r['fit_level'] ?? '',
                        'growth_potential' => $r['growth_potential'] ?? '',
                        'work_environment' => $r['work_environment'] ?? '',
                    ];
                    break;
                }
                // also allow numeric index match when JSON uses array positions as job ids
                if ((string) $idx === (string) $job_id) {
                    $r = $rows[$idx];
                    $job = [
                        'title' =>
                            trim($r['Title'] ?? ($r['title'] ?? '')) ?:
                            (strlen(trim($r['job_description'] ?? ''))
                                ? Str::limit($r['job_description'], 80)
                                : 'Untitled Job'),
                        'company' => trim($r['Company'] ?? ($r['company'] ?? '')),
                        'job_description' => $r['job_description'] ?? ($r['description'] ?? ''),
                        'job_requirement' => $r['resume'] ?? ($r['job_requirement'] ?? ''),
                        'location' => $r['location'] ?? '',
                        'hours' => $r['formatted_work_type'] ?? ($r['hours'] ?? ''),
                        'salary' => $r['salary'] ?? ($r['Salary'] ?? null),
                        'start_date' => $r['original_listed_time'] ?? null,
                        'deadline' => $r['deadline'] ?? null,
                        'announcement_code' => $r['announcement_code'] ?? '',
                        'job_posting_url' => $r['job_posting_url'] ?? '',
                        'application_url' => $r['application_url'] ?? '',
                        'fit_level' => $r['fit_level'] ?? '',
                        'growth_potential' => $r['growth_potential'] ?? '',
                        'work_environment' => $r['work_environment'] ?? '',
                    ];
                    break;
                }
            }
        }

        // If not found in recommendations.json, fall back to CSV parsing
        if ($job === null && $job_id !== null && file_exists($csv_path)) {
            if (($handle = fopen($csv_path, 'r')) !== false) {
                $header = fgetcsv($handle);
                $cols = array_map(
                    function ($h) {
                        return trim($h);
                    },
                    $header ?: [],
                );
                $numCols = count($cols);
                if ($numCols === 0) {
                    fclose($handle);
                    return;
                }
                // same inference helpers as job-matches
                $infer_fit_level = function (string $text) {
                    $t = strtolower($text);
                    $excellent = [
                        'excellent',
                        'perfect',
                        'highly suitable',
                        'highly qualified',
                        'strong match',
                        'ideal',
                    ];
                    foreach ($excellent as $k) {
                        if (strpos($t, $k) !== false) {
                            return 'Excellent Fit';
                        }
                    }
                    $good = ['good fit', 'good', 'suitable', 'appropriate', 'fit'];
                    foreach ($good as $k) {
                        if (strpos($t, $k) !== false) {
                            return 'Good Fit';
                        }
                    }
                    return '';
                };
                $infer_growth_potential = function (string $text) {
                    $t = strtolower($text);
                    $high = [
                        'promotion',
                        'career growth',
                        'growth',
                        'advance',
                        'development',
                        'opportunity',
                        'career advancement',
                        'leadership',
                    ];
                    foreach ($high as $k) {
                        if (strpos($t, $k) !== false) {
                            return 'High Potential';
                        }
                    }
                    $medium = ['entry level', 'entry-level', 'trainee', 'starter', 'mid-level'];
                    foreach ($medium as $k) {
                        if (strpos($t, $k) !== false) {
                            return 'Medium Potential';
                        }
                    }
                    return '';
                };
                $infer_work_environment = function (string $text) {
                    $t = strtolower($text);
                    $quiet = ['quiet', 'calm', 'low noise', 'private', 'peaceful', 'indoor quiet'];
                    foreach ($quiet as $k) {
                        if (strpos($t, $k) !== false) {
                            return 'Quiet';
                        }
                    }
                    $busy = ['busy', 'fast-paced', 'high energy', 'crowd', 'bustling', 'active environment'];
                    foreach ($busy as $k) {
                        if (strpos($t, $k) !== false) {
                            return 'Busy';
                        }
                    }
                    return '';
                };

                $i = 0;
                $maxRows = 5000;
                while (($row = fgetcsv($handle)) !== false) {
                    if (count($row) < $numCols) {
                        $row = array_merge($row, array_fill(0, $numCols - count($row), ''));
                    } elseif (count($row) > $numCols) {
                        $row = array_slice($row, 0, $numCols);
                    }
                    if (count($row) !== $numCols) {
                        continue;
                    }
                    if ($i >= $maxRows) {
                        break;
                    }
                    // Build associative row and try to match by explicit job_id-like columns first
                    $assoc = array_combine($cols, $row) ?: [];
                    $found = false;
                    // normalize keys to lower for lookup
                    $normRow = [];
                    foreach ($assoc as $k => $v) {
                        $normRow[strtolower(preg_replace('/[^a-z0-9]+/i', '_', trim((string) $k)))] = $v;
                    }
                    $candidateJobId = null;
                    if (isset($normRow['job_id'])) {
                        $candidateJobId = (string) $normRow['job_id'];
                    } elseif (isset($normRow['jobid'])) {
                        $candidateJobId = (string) $normRow['jobid'];
                    } elseif (isset($normRow['id'])) {
                        $candidateJobId = (string) $normRow['id'];
                    }
                    // If provided job_id matches a field in the row, select this row. Otherwise, fall back to numeric index match.
                    if (
                        $candidateJobId !== null &&
                        (string) $job_id !== '' &&
                        (string) $candidateJobId === (string) $job_id
                    ) {
                        $found = true;
                    } elseif (is_numeric($job_id) && intval($job_id) === $i) {
                        $found = true;
                    }
                    if ($found) {
                        $textForInference = trim(
                            ($assoc['JobDescription'] ?? '') .
                                ' ' .
                                ($assoc['JobRequirment'] ?? '') .
                                ' ' .
                                ($assoc['jobpost'] ?? ''),
                        );
                        $inferred_fit = $infer_fit_level($textForInference);
                        $inferred_growth = $infer_growth_potential($textForInference);
                        $inferred_env = $infer_work_environment($textForInference);
                        // Robust field extraction with multiple header fallbacks
                        $title = trim(
                            $assoc['title'] ?? ($assoc['Title'] ?? ($assoc['jobpost'] ?? ($assoc['job_title'] ?? ''))),
                        );
                        $company = trim($assoc['company_name'] ?? ($assoc['Company'] ?? ($assoc['Employer'] ?? '')));
                        $description = trim(
                            $assoc['description'] ??
                                ($assoc['JobDescription'] ?? ($assoc['JobRequirment'] ?? ($assoc['jobpost'] ?? ''))),
                        );
                        $requirement = trim(
                            $assoc['job_requirement'] ??
                                ($assoc['JobRequirment'] ?? ($assoc['RequiredQual'] ?? ($assoc['skills_desc'] ?? ''))),
                        );
                        $location = trim($assoc['location'] ?? ($assoc['Location'] ?? ($assoc['City'] ?? '')));
                        // hours: prefer formatted_work_type (Full-time/Part-time) or Duration/Term, or parse 'Expected hours' from description
                        $hours = trim(
                            $assoc['formatted_work_type'] ??
                                ($assoc['Duration'] ?? ($assoc['Term'] ?? ($assoc['Hours'] ?? ''))),
                        );
                        if ($hours === '') {
                            if (preg_match('/Expected hours:\s*([^\r\n]+)/i', $description, $m)) {
                                $hours = trim($m[1]);
                            }
                        }
                        // salary: prefer normalized or max/min
                        $salary = $assoc['normalized_salary'] ?? ($assoc['max_salary'] ?? ($assoc['Salary'] ?? ''));
                        $start_date = $assoc['StartDate'] ?? ($assoc['original_listed_time'] ?? '');
                        $deadline = $assoc['Deadline'] ?? ($assoc['expiry'] ?? ($assoc['closed_time'] ?? ''));
                        $announcement_code = $assoc['AnnouncementCode'] ?? ($assoc['announcement_code'] ?? '');
                        $job_posting_url =
                            $assoc['job_posting_url'] ??
                            ($assoc['job_posting_url'] ?? ($assoc['job_posting_link'] ?? ''));
                        $application_url = $assoc['application_url'] ?? ($assoc['application_url'] ?? '');

                        $job = [
                            'title' => $title ?: ($description ? Str::limit($description, 80) : 'Untitled Job'),
                            'company' => $company,
                            'job_description' => $description,
                            'job_requirement' => $requirement,
                            'location' => $location,
                            'hours' => $hours,
                            'salary' => $salary,
                            'start_date' => $start_date,
                            'deadline' => $deadline,
                            'announcement_code' => $announcement_code,
                            'job_posting_url' => $job_posting_url,
                            'application_url' => $application_url,
                            'fit_level' => $assoc['fit_level'] ?? ($assoc['FitLevel'] ?? $inferred_fit),
                            'growth_potential' =>
                                $assoc['growth_potential'] ?? ($assoc['GrowthPotential'] ?? $inferred_growth),
                            'work_environment' =>
                                $assoc['work_environment'] ??
                                ($assoc['WorkEnvironment'] ?? ($inferred_env ?? $location)),
                        ];
                        break;
                    }
                    $i++;
                }
                fclose($handle);
            }
        }
    @endphp


    <!-- Back Button -->
    <div class="bg-yellow-400 py-5 px-6 sm:px-10">
        <div class="flex items-center space-x-3">
            <a href="{{ route('job.matches') }}"
                class="flex items-center space-x-3 text-[#1E40AF] font-bold text-xl sm:text-3xl hover:underline focus:outline-none transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-10 h-10 sm:w-8 sm:h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Back to Jobs</span>
            </a>
        </div>
    </div>

    <!-- GREEN NOTE -->
    <div class="bg-green-100 border-[4px] border-green-400 rounded-lg p-5 mt-14 mx-4 sm:mx-10">
        <div class="flex items-center gap-6">
            <img src="{{ asset('image/bulb.png') }}" alt="Lightbulb Icon"
                class="w-14 h-14 sm:w-16 sm:h-16 object-contain flex-shrink-0">

            <!-- Text Section -->
            <div class="flex flex-col justify-center leading-snug">
                <p class="text-2xl sm:text-2xl font-semibold text-black">
                    The content shown here gives more detailed information about the job.
                </p>
                <p class="mt-2 italic text-gray-700 text-xl">
                    (Ang nakikitang nilalaman dito ay mas detalyadong impormasyon tungkol sa trabaho.)
                </p>
            </div>
        </div>
    </div>

    <!-- APPLY NOTE -->
    <div class="bg-gray-50 border-[4px] border-gray-300 rounded-lg p-5 mt-8 mx-4 sm:mx-10">
        <div class="flex items-center gap-6">
            <!-- Info Icon -->
            <i class="ri-information-line text-[#1E40AF] text-[2.8rem] sm:text-[3.5rem] flex-shrink-0"></i>

            <!-- Text Content -->
            <div class="flex flex-col justify-center leading-snug">
                <p class="text-2xl sm:text-2xl text-black font-semibold">
                    Click the <span class="text-blue-600 font-bold">“Apply”</span> button to go to the application form for
                    this job.
                </p>
                <p class="mt-2 italic text-gray-700 text-xl">
                    (Pindutin ang Apply button upang mapunta sa application form para sa trabahong ito.)
                </p>
            </div>
        </div>
    </div>

    <!-- JOB DETAILS SECTION -->
    <div class="mt-16 mx-4 sm:mx-10 my-8">
        <h2 class="text-5xl font-extrabold text-[#1E40AF] mb-6 text-center">Job Details</h2>

        <!-- Job Header -->
        <div
            class="mt-12 bg-[#F0F9FF] border-[2px] border-[#1E40AF] rounded-xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-10 bg-white shadow-sm">

            <!-- Company Logo -->
            <div class="flex items-center justify-center sm:justify-start w-full sm:w-auto">
                @if (!empty($company->logo))
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo"
                        class="w-24 h-24 rounded-xl border border-gray-300 object-cover">
                @else
                    <div class="w-24 h-24 flex items-center justify-center rounded-xl border-4 border-gray-300 bg-gray-50">
                        <i class="ri-building-4-fill text-[#1E40AF] text-6xl"></i>
                    </div>
                @endif
            </div>

            <!-- Job Information -->
            <div class="flex flex-col items-center sm:items-start text-center sm:text-left flex-grow">
                <h3 class="text-2xl sm:text-3xl font-bold text-black">Pet Care Assistant</h3>
                <p class="text-gray-700 text-lg sm:text-xl mt-2">BGC · Taguig City, PH</p>
                <span
                    class="text-[#88BF02] border border-[#88BF02] text-base font-semibold px-4 py-1 rounded-md mt-3 inline-block">
                    Full Support
                </span>
            </div>

            <!-- Apply Button -->
            <div class="flex justify-center sm:justify-end w-full sm:w-auto">
                <button
                    class="bg-[#1E40AF] text-white text-lg sm:text-xl px-14 py-3 rounded-none font-semibold hover:bg-blue-900 transition duration-300 shadow-md">
                    Apply
                </button>
            </div>
        </div>

        <!-- JOB INFO GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-10">

            <!-- LEFT CONTENT -->
            <div class="col-span-2 space-y-6">
                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Job Description</h4>
                </div>

                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Responsibilities</h4>
                </div>

                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Requirements</h4>
                </div>

                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Preferred Candidates</h4>
                </div>

                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-2">Purpose</h4>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="space-y-6">

                <!-- About this role -->
                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-xl font-bold text-black mb-3">About this Role</h4>
                    <div class="h-5 bg-gray-200 mb-2">
                        <div class="h-5 bg-[#88BF02] w-1/2"></div>
                    </div>
                    <p class="text-lg font-semibold mb-3">
                        <span class="text-black">5 applied</span>
                        <span class="text-gray-600"> of 10 capacity</span>
                    </p>
                    <div class="grid grid-cols-2 gap-y-2 text-base">
                        <p class="text-gray-500 font-medium">Apply Before</p>
                        <p class="text-right text-gray-800 font-semibold">September 20, 2025</p>

                        <p class="text-gray-500 font-medium">Job Posted On</p>
                        <p class="text-right text-gray-800 font-semibold">August 30, 2025</p>

                        <p class="text-gray-500 font-medium">Job Type</p>
                        <p class="text-right text-gray-800 font-semibold">Full-Time</p>
                    </div>
                </div>

                <!-- Required Skills -->
                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg font-bold text-black mb-3">Required Skills</h4>
                    <div class="flex flex-wrap gap-4">
                        <span
                            class="text-[#2563EB] border border-[#2563EB] text-sm font-semibold px-3 py-1 rounded-md">Teamwork</span>
                        <span
                            class="text-[#2563EB] border border-[#2563EB] text-sm font-semibold px-3 py-1 rounded-md">Cleaning</span>
                        <span
                            class="text-[#2563EB] border border-[#2563EB] text-sm font-semibold px-3 py-1 rounded-md">Patience</span>
                        <span
                            class="text-[#2563EB] border border-[#2563EB] text-sm font-semibold px-3 py-1 rounded-md">Empathy</span>
                    </div>
                </div>

                <!-- Job Program -->
                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg  font-bold text-black mb-3">Job Program</h4>
                    <p class="text-[#88BF02] border border-[#88BF02] px-3 py-1 rounded-md font-semibold inline-block">Love
                        ’Em Down</p>
                </div>

                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg  font-bold text-black mb-3">Hiring Manager</h4>
                    <div class="flex items-center gap-3">
                        <!-- Profile Image Placeholder -->
                        <div
                            class="w-12 h-12 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center overflow-hidden">
                            <i class="ri-user-line text-gray-400 text-2xl"></i>
                            <!--
                                   <img src="path-to-profile.jpg" alt="Profile" class="w-full h-full object-cover hidden"
                                    onerror="this.classList.add('hidden'); this.previousElementSibling.classList.remove('hidden');" />
                                    -->
                        </div>

                        <!-- Name and Title -->
                        <div class="flex flex-col">
                            <p class="font-medium text-base text-gray-800">John Carlo Garcia</p>
                            <p class="text-gray-500 text-xs">Human Resources Manager</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="border border-gray-300 bg-white rounded-none p-6 shadow-md">
                    <h4 class="text-lg  font-bold text-black mb-3">Contact Details</h4>
                    <p class="text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-map-pin-line text-black text-lg"></i>
                        Lot 8 Blk W-39E Quezon Avenue, cor Jose Abad Santos St., Quezon City, Metro Manila
                    </p>
                    <p class="mt-2 text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-phone-line text-black text-lg"></i> +63 5587 1234
                    </p>
                    <p class="mt-2 text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-mail-line text-black text-lg"></i> Juan.Carl@shakeys.com
                    </p>
                    <p class="mt-2  text-sm font-regular text-gray-600 flex items-start gap-4">
                        <i class="ri-building-4-line text-black text-lg"></i> Restaurant
                    </p>
                    <a href="https://www.shakeyspizza.ph/sustainability/people" target="_blank"
                        class="mt-2  text-blue-500 text-sm flex items-center gap-4 hover:underline">
                        <i class="ri-link text-black text-lg"></i> https://www.shakeyspizza.ph/
                    </a>
                    <a href="https://maps.app.goo.gl/xTquSe3sPdryda7" target="_blank"
                        class="mt-2  text-blue-500 text-sm flex items-center gap-4 hover:underline">
                        <i class="ri-map-2-line text-black text-lg"></i> Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- BACK TO TOP BUTTON -->
    <button id="backToTopBtn"
        class="hidden fixed bottom-8 right-8 bg-[#1E40AF] text-white px-6 py-4 rounded-full shadow-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110 flex items-center gap-3 text-2xl font-semibold"
        onclick="scrollToTop()" aria-label="Back to top">

        <!-- Up Arrow Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>

        <span>Back to Top</span>
    </button>

    <script>
        // Show/hide the Back to Top button
        const backToTopBtn = document.getElementById("backToTopBtn");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove("hidden");
            } else {
                backToTopBtn.classList.add("hidden");
            }
        });

        // Smooth scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }
    </script>



    <!-- Job Details Section -->
    @if ($job)
        <section class="max-w-5xl mx-auto mt-10 px-4">
            <div class="flex flex-col items-center">
                <img src="/images/ipetclub.png" alt="iPet Club" class="w-40 h-40 object-contain mb-4">
                <div class="flex space-x-4 mb-6">
                    @php
                        // Try Firestore approvals when uid param provided, else fall back to local file
                        $guardianApprovals = [];
                        $uidParam = request()->query('uid');
                        if (!empty($uidParam)) {
                            try {
                                $fs = app(
                                    \App\Http\Controllers\GuardianJobController::class,
                                )->fetchApprovalsFromFirestore($uidParam);
                                if (is_array($fs)) {
                                    $guardianApprovals = $fs;
                                }
                            } catch (\Throwable $e) {
                                logger()->warning('Firestore fetch failed in job-details: ' . $e->getMessage());
                            }
                        }
                        if (empty($guardianApprovals)) {
                            $approvals_path = storage_path('app/guardian_job_approvals.json');
                            if (file_exists($approvals_path)) {
                                $guardianApprovals = json_decode(file_get_contents($approvals_path), true) ?: [];
                            }
                        }
                        $isApproved = false;
                        $isFlagged = false;
                        $approvalRec = null;
                        // Normalize 'p' prefix (used by some client-side renderers) and keep multiple possible keys
                        $jid = (string) $job_id;
                        if (is_string($jid) && preg_match('/^p(\d+)$/i', $jid, $m)) {
                            $jid = (string) intval($m[1]);
                        }
                        // Try multiple possible keys because job ids may be stored as numeric index, explicit job_id column, or prefixed (e.g. 'p0')
                        $possibleKeys = [$jid];
                        if (is_numeric($jid)) {
                            $possibleKeys[] = (string) intval($jid);
                            $possibleKeys[] = 'p' . (string) intval($jid);
                        }
                        // If job row/raw info present, try common raw id fields and row_index
                        if (!empty($job['raw']) && is_array($job['raw'])) {
                            $raw = $job['raw'];
                            if (isset($raw['job_id'])) {
                                $possibleKeys[] = (string) $raw['job_id'];
                            }
                            if (isset($raw['jobid'])) {
                                $possibleKeys[] = (string) $raw['jobid'];
                            }
                            if (isset($raw['id'])) {
                                $possibleKeys[] = (string) $raw['id'];
                            }
                        }
                        if (isset($job['row_index'])) {
                            $possibleKeys[] = (string) $job['row_index'];
                        }
                        // normalize and dedupe
                        $possibleKeys = array_values(
                            array_unique(
                                array_filter($possibleKeys, function ($x) {
                                    return strlen((string) $x) > 0;
                                }),
                            ),
                        );
                        foreach ($possibleKeys as $k) {
                            if (isset($guardianApprovals[$k])) {
                                $approvalRec = $guardianApprovals[$k];
                                $st = $approvalRec['status'] ?? '';
                                if ($st === 'approved') {
                                    $isApproved = true;
                                }
                                if ($st === 'flagged') {
                                    $isFlagged = true;
                                }
                                break;
                            }
                        }
                    @endphp

                    @if ($isApproved)
                        <a href="{{ route('job.application.1', ['job_id' => $job_id]) }}"
                            class="bg-pink-500 text-white px-6 py-2 rounded hover:bg-pink-600 transition">Apply</a>
                    @else
                        <button class="bg-gray-300 text-gray-700 px-6 py-2 rounded" disabled
                            title="This job is pending guardian approval">Apply (Pending Guardian)</button>
                    @endif

                    <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Saved</button>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h2 class="text-2xl font-bold text-gray-800">{{ $job['title'] ?: $job['job_description'] }}</h2>
                @if (!empty($job['company']))
                    <p class="text-sm text-gray-700 font-medium">{{ $job['company'] }}</p>
                @endif
                <div class="flex items-center text-gray-600 text-sm space-x-3 mt-2">
                    @if (!empty($job['location']))
                        <span class="bg-gray-100 text-xs px-3 py-1 rounded">{{ $job['location'] }}</span>
                    @endif
                    @if (!empty($job['start_date']))
                        <span class="bg-gray-100 text-xs px-3 py-1 rounded">Starts: {{ $job['start_date'] }}</span>
                    @endif
                </div>
                <div class="mt-5">
                    <h3 class="font-semibold text-gray-700">Job Description:</h3>
                    <p class="text-gray-700 text-sm mt-2">{{ $job['job_description'] ?? ($job['description'] ?? '') }}</p>
                </div>
                <div class="mt-5">
                    <h3 class="font-semibold text-gray-700">Resume Example:</h3>
                    <p class="text-gray-600 text-sm mt-2">{{ $job['job_requirement'] }}</p>
                </div>
                <div class="mt-5">
                    <h3 class="font-semibold text-gray-700">Job Fit Level & Potential</h3>
                    <div class="flex flex-wrap gap-2 mt-2">
                        {{-- no direct fit/growth data in CSV; show placeholders if available --}}
                        @if (!empty($job['announcement_code']))
                            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded">Code:
                                {{ $job['announcement_code'] }}</span>
                        @endif
                        @if (!empty($job['salary']))
                            <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded">Salary:
                                {{ $job['salary'] }}</span>
                        @endif
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4">Deadline: {{ $job['deadline'] ?? '-' }}</p>
                @if ($approvalRec)
                    <div class="mt-4 p-3 border rounded bg-gray-50">
                        <div class="text-sm font-semibold">Guardian Review Status: <span
                                class="inline-block px-2 py-1 rounded text-white {{ $isApproved ? 'bg-green-600' : ($isFlagged ? 'bg-red-600' : 'bg-yellow-600') }}">{{ $approvalRec['status'] ?? 'pending' }}</span>
                        </div>
                        <div class="text-xs text-gray-600 mt-1">Actioned by: {{ $approvalRec['actioned_by'] ?? '-' }}
                            &middot; At: {{ $approvalRec['actioned_at'] ?? '-' }}</div>
                        @if (!empty($approvalRec['feedback']))
                            <div class="mt-2 text-sm">Feedback: {{ Str::limit($approvalRec['feedback'], 500) }}</div>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    @else
        <div class="max-w-5xl mx-auto mt-10 px-4">
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded">
                No job details found. Please select a job from <a href="{{ route('job.matches') }}"
                    class="underline text-blue-600">Job Matches</a>.
            </div>
        </div>
    @endif

    <!-- Ensure global Firebase config is present and require login for actions on this page -->
    {{-- Firebase removed: firebase-config-global.js intentionally omitted --}}
    <script>
        @auth
        window.__SERVER_AUTH = true;
        @else
            window.__SERVER_AUTH = false;
        @endauth
    </script>
    {{-- <script type="module">
        (async function() {
            try {
                const mod = await import("{{ asset('js/job-application-firebase.js') }}");
                console.debug('Auth guard: waiting for sign-in resolution (7s)');
                const signed = await mod.isSignedIn(7000);
                console.debug('Auth guard: isSignedIn ->', signed);
                if (!signed) {
                    if (window.__SERVER_AUTH) {
                        console.info('Auth guard: server session present, not redirecting');
                        return;
                    }
                    const current = window.location.pathname + window.location.search;
                    console.info('Auth guard: not signed, redirecting to login');
                    window.location.href = 'login?redirect=' + encodeURIComponent(current);
                    return;
                }
                // signed-in users proceed; no further client setup required here
            } catch (err) {
                console.error('Auth guard failed on job details', err);
            }
        })();
    </script> --}}
@endsection
