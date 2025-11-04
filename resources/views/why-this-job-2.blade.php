@extends('layouts.includes')

@section('content')


<!-- Back Button -->
<div class="bg-yellow-400 w-full py-5 px-4 sm:px-8 lg:px-20">
  <div class="flex justify-start items-center space-x-3 max-w-7xl mx-auto">
    <a href="/jobmatches"
      class="flex items-center space-x-3 text-[#1E40AF] font-bold text-2xl sm:text-3xl hover:underline focus:outline-none transition-all">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span>Back to Jobs</span>
    </a>
  </div>
</div>

<!-- HERO SECTION -->
<section class="bg-pink-400 py-10 text-center shadow-md rounded-b-3xl">
  <div class="flex flex-col items-center justify-center">
    <img src="{{ asset('image/brain.png') }}" alt="Brain Icon" 
         class="w-24 h-24 mb-3 animate-bounce-slow">
    <h2 class="text-4xl font-extrabold text-white tracking-wide drop-shadow-md">
      Why This Job Match You?
    </h2>
    <p class="text-lg text-white/90 mt-2 max-w-2xl">
      Discover how your unique skills and interests align with this job role.  
    </p>
  </div>
</section>


<!-- Main Content Container -->
<section class="max-w-8xl mx-auto mt-16 mb-20 px-8 space-y-10">

  @php
    $job = $job ?? null;
    $jobTitle = $job['assoc']['title'] ?? ($job['assoc']['job_title'] ?? 'Untitled Job');
    $company = $job['assoc']['company'] ?? '';
    $jobDescription = $job['job_description'] ?? '';
    $jobSkills = is_array($job['assoc']['skills'] ?? null) ? $job['assoc']['skills'] : (is_array($job['skills'] ?? null) ? $job['skills'] : []);
    $matchPercent = null;
    if (isset($job['match_score']) && is_numeric($job['match_score'])) {
        $m = floatval($job['match_score']);
        if ($m > 0 && $m <= 1.01) $matchPercent = round($m * 100);
        elseif ($m > 0 && $m <= 5.0) $matchPercent = round($m * 20);
        else $matchPercent = round($m);
    }
  @endphp

  <!-- Job card for selected job -->
  <div class="bg-yellow-100 border-4 border-yellow-300 rounded-3xl shadow-lg p-8 space-y-4 transition hover:shadow-2xl">
    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
      <div class="flex items-center space-x-4">
        <img src="{{ asset('image/nameofjob.png') }}" alt="Job Icon" class="w-12 h-12">
        <h3 class="text-3xl font-extrabold text-blue-900">{{ $jobTitle }}</h3>
      </div>
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
        <span class="text-lg bg-green-200 text-green-900 px-4 py-1 rounded-full font-semibold shadow">
          {{ $matchPercent !== null ? ($matchPercent . '% Match for You') : 'Matched' }}
        </span>
        <span class="text-lg bg-green-300 text-green-900 px-4 py-1 rounded-full font-semibold shadow">
          {{ $matchPercent !== null && $matchPercent >= 75 ? 'Excellent Match' : ($matchPercent !== null && $matchPercent >= 50 ? 'Good Match' : 'Potential Match') }}
        </span>
      </div>
    </div>

    <h4 class="text-2xl font-bold text-blue-900 mt-4">Why this Job Matches You 💡</h4>
    @php $whySentence = $job['why_sentence'] ?? null; @endphp
    @if($whySentence)
      <div class="text-lg text-gray-800 italic mb-3">{{ $whySentence }}</div>
    @endif

    <div class="bg-white rounded-2xl p-4 border-2 border-blue-100 text-lg text-gray-800">
      @if($jobDescription)
        <p>{{ $jobDescription }}</p>
      @else
        <p>This job was recommended because it aligns with your skills and preferences.</p>
      @endif
    </div>

    <ul class="list-disc ml-6 text-lg space-y-3 text-gray-800 mt-4">
      @if(!empty($jobSkills))
        @foreach(array_slice($jobSkills,0,6) as $s)
          <li><strong>{{ $s }}</strong>
            <span class="block text-gray-600 italic text-base">(This skill matches your profile)</span>
          </li>
        @endforeach
      @else
        <li>We didn't find explicit required skills in the job listing — the recommendation algorithm matched this job based on related skills and interests.</li>
      @endif
    </ul>
  </div>

  <!-- What is this Job Card (Matched to Possible Section Size) -->
<div class="bg-blue-100 border-4 border-blue-300 rounded-3xl shadow-lg p-12 transition hover:shadow-2xl hover:scale-[1.015] duration-300">
  <div class="flex flex-col sm:flex-row sm:items-center mb-8 space-y-3 sm:space-y-0 sm:space-x-5">
    <img src="{{ asset('image/whatisthisjob.png') }}" alt="Info" class="w-14 h-14">
    <div>
      <h4 class="text-4xl font-extrabold text-blue-900">What is this Job?</h4>
      <span class="text-xl text-gray-700 italic block mt-2">(Ano ang Trabahong Ito?)</span>
    </div>
  </div>

  <div class="bg-white rounded-3xl border-2 border-blue-200 p-10 text-xl text-gray-800 leading-relaxed shadow-inner">
    <p class="text-blue-900 font-medium text-2xl mb-4">Job Overview</p>
    <p>
      A <strong>Kitchen Helper</strong> works in a restaurant kitchen to keep everything clean, organized, and running smoothly! 
      They support cooks, maintain cleanliness, and ensure food preparation areas are ready for use.
    </p>
    <p class="text-gray-600 italic mt-3">
      (Ang <strong>Katulong sa Kusina</strong> ay nagtatrabaho sa kusina ng restawran upang mapanatiling malinis, maayos, at maayos ang takbo ng lahat. 
      Sila ay sumusuporta sa mga cook, naglilinis, at naghahanda ng mga lugar para sa pagluluto.)
    </p>

    <hr class="my-8 border-blue-200">

    <p class="text-blue-900 font-medium text-2xl mb-4">Ideal for You If...</p>
    <p>
      This is a perfect job if you enjoy working with your hands, following clear steps, and being part of a busy, cooperative team. 
      You’ll gain experience, develop practical skills, and grow in a supportive kitchen environment.
    </p>
    <p class="text-gray-600 italic mt-3">
      (Ito ay perpektong trabaho kung mahilig kang gumamit ng iyong mga kamay, sumusunod sa malinaw na mga hakbang, 
      at gustong maging bahagi ng isang abalang grupo. Matututo ka ng mga bagong kasanayan araw-araw sa isang kapaligirang nagtutulungan.)
    </p>
  </div>
</div>

  <!-- Possible You Will Do in this Job -->
<div class="bg-green-100 border-4 border-green-300 rounded-3xl shadow-xl p-12 transition hover:shadow-2xl hover:scale-[1.015] duration-300">
  <div class="flex flex-col sm:flex-row sm:items-center mb-8 space-y-3 sm:space-y-0 sm:space-x-5">
    <img src="{{ asset('image/checkmark.png') }}" alt="Check" class="w-14 h-14">
    <div>
      <h4 class="text-4xl font-extrabold text-green-900">Possible You Will Do in this Job</h4>
      <span class="text-xl text-gray-700 italic block">(Mga Posibleng Gawin sa Trabahong Ito)</span>
    </div>
  </div>

  <div class="bg-white rounded-3xl border-2 border-green-200 p-10 text-xl text-gray-800 leading-relaxed shadow-inner">
    <p class="text-green-900 font-semibold text-2xl mb-6">🧾 Sample Preview Tasks</p>

    <ul class="list-disc ml-6 space-y-6">
      <li>
        <strong>Assist with Daily Tasks:</strong> Help in preparing, cleaning, and organizing the workspace.
        <span class="block text-gray-600 italic text-base">(Halimbawa: Tumulong sa paghahanda, paglilinis, at pag-aayos ng lugar ng trabaho.)</span>
      </li>
      <li>
        <strong>Support the Team:</strong> Work with other staff to ensure smooth and efficient operations.
        <span class="block text-gray-600 italic text-base">(Halimbawa: Makipagtulungan sa mga kasamahan para sa maayos na daloy ng trabaho.)</span>
      </li>
      <li>
        <strong>Maintain Equipment:</strong> Ensure tools, utensils, and materials are in good condition.
        <span class="block text-gray-600 italic text-base">(Halimbawa: Siguraduhing maayos ang mga gamit at kagamitan bago at matapos gamitin.)</span>
      </li>
      <li>
        <strong>Follow Safety Procedures:</strong> Apply safety and hygiene practices while working.
        <span class="block text-gray-600 italic text-base">(Halimbawa: Sundin ang mga patakaran sa kaligtasan at kalinisan.)</span>
      </li>
    </ul>

    <div class="mt-10 text-center">
      <p class="text-gray-700 italic text-base">*This is a sample preview only — actual tasks will be provided by experts.*</p>
    </div>
  </div>

  <!-- Images -->
  <div class="flex justify-center gap-8 mt-12 flex-wrap">
    <!-- Placeholder with icon -->
    <div class="w-64 h-64 rounded-3xl border-2 border-green-300 shadow-lg bg-gradient-to-br from-green-200 to-green-100 flex flex-col items-center justify-center text-green-800 font-semibold text-center space-y-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-700 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
      </svg>
      <span class="text-lg">Image 1</span>
    </div>

    <div class="w-64 h-64 rounded-3xl border-2 border-green-300 shadow-lg bg-gradient-to-br from-green-200 to-green-100 flex flex-col items-center justify-center text-green-800 font-semibold text-center space-y-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-700 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
      </svg>
      <span class="text-lg">Image 2</span>
    </div>

    <div class="w-64 h-64 rounded-3xl border-2 border-green-300 shadow-lg bg-gradient-to-br from-green-200 to-green-100 flex flex-col items-center justify-center text-green-800 font-semibold text-center space-y-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-700 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
      </svg>
      <span class="text-lg">Image 3</span>
    </div>

      <div class="w-64 h-64 rounded-3xl border-2 border-green-300 shadow-lg bg-gradient-to-br from-green-200 to-green-100 flex flex-col items-center justify-center text-green-800 font-semibold text-center space-y-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-700 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15l-5-5L5 21" />
      </svg>
      <span class="text-lg">Image 4</span>
    </div>
  </div>
</div>
</section>

<!-- BACK TO TOP BUTTON -->
<button id="backToTopBtn"
  class="hidden fixed bottom-8 right-8 bg-[#1E40AF] text-white px-6 py-4 rounded-full shadow-xl hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 transition transform hover:scale-110 flex items-center gap-3 text-2xl font-semibold"
  onclick="scrollToTop()" aria-label="Back to top">
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
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
  </script>



<script type="module">
  (async function(){
    try {
      const mod = await import('/js/job-application-firebase.js');
      try { await mod.ensureInit?.(); } catch(e){}
  try { /* firebase.token removed */ } catch(e) { /* ignore */ }
      let profile = null;
      try { profile = await (mod.getUserProfile?.() || Promise.resolve(null)); } catch(e) { profile = null; }

      // Normalize profile skills
      const profileSkills = [];
      try {
        if (profile) {
          if (profile.skills && typeof profile.skills === 'object') {
            try { if (profile.skills.skills_page1) JSON.parse(profile.skills.skills_page1).forEach(x=>profileSkills.push(String(x).toLowerCase().trim())); } catch(e){}
            try { if (profile.skills.skills_page2) JSON.parse(profile.skills.skills_page2).forEach(x=>profileSkills.push(String(x).toLowerCase().trim())); } catch(e){}
          }
          if (Array.isArray(profile.skills)) profile.skills.forEach(s=>profileSkills.push(String(s).toLowerCase().trim()));
          if (typeof profile.skills === 'string') profile.skills.split(/[,;\n]+/).forEach(s=>profileSkills.push(String(s).toLowerCase().trim()));
          if (Array.isArray(profile.interests)) profile.interests.forEach(s=>profileSkills.push(String(s).toLowerCase().trim()));
          if (typeof profile.interests === 'string') profile.interests.split(/[,;\n]+/).forEach(s=>profileSkills.push(String(s).toLowerCase().trim()));
        }
      } catch(e) { console.debug('normalize profile skills failed', e); }
      const cleanedProfileSkills = Array.from(new Set(profileSkills.filter(Boolean)));

      const JOB_SKILLS = @json($jobSkills);
      const jobSkills = (Array.isArray(JOB_SKILLS) ? JOB_SKILLS.map(s=>String(s).toLowerCase().trim()).filter(Boolean) : []);

      // compute matched skills
      const matched = jobSkills.filter(s => cleanedProfileSkills.includes(s));

      // update matching-skills-list
      const skillsList = document.querySelector('.matching-skills-list');
      if (skillsList) {
        skillsList.innerHTML = '';
        if (jobSkills.length === 0) {
          skillsList.innerHTML = '<span class="text-sm text-gray-500">No specific skills were listed for this job.</span>';
        } else {
          jobSkills.slice(0,6).forEach(s => {
            const span = document.createElement('span');
            span.className = (matched.includes(s) ? 'bg-blue-50 text-blue-500 px-4 py-1 rounded-full text-sm font-medium' : 'bg-gray-100 text-gray-500 px-4 py-1 rounded-full text-sm');
            span.textContent = s;
            skillsList.appendChild(span);
          });
        }
      }

      // update client matched skills area
      const clientMatchContainer = document.querySelector('.client-matched-skills');
      if (clientMatchContainer) {
        if (!matched || matched.length === 0) clientMatchContainer.innerHTML = '<p class="text-sm text-gray-500">No matching skills from your profile were detected for this job.</p>';
        else clientMatchContainer.innerHTML = '<p class="text-sm text-gray-700 font-medium">Skills from your profile that match this job:</p><div class="flex flex-wrap gap-3 mt-2">' + matched.map(s => '<span class="bg-green-50 text-green-600 px-4 py-1 rounded-full text-sm font-medium">'+String(s).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;")+'</span>').join('') + '</div>';
      }

      // compute a fallback percent if none present
      const badge = document.querySelector('.match-badge');
      const prog = document.querySelector('.match-progress');
      const label = document.querySelector('.match-percent-label');
      let pct = null;
      if ({{ $matchPercent !== null ? 'true' : 'false' }}) {
        // leave server-provided percent as-is
      } else {
        if (jobSkills.length > 0) pct = Math.round((matched.length / jobSkills.length) * 100);
        else pct = null;
        if (badge && pct !== null) badge.textContent = pct + '% Match';
        if (prog && pct !== null) prog.style.width = pct + '%';
        if (label && pct !== null) label.textContent = pct + '%';
      }
    } catch(e) { console.debug('why-this-job-2 client update failed', e); }
  })();
</script>

@endsection