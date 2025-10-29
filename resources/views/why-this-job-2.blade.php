@extends('layouts.includes')

@section('content')

<div class="font-sans bg-white text-gray-800">

  <!-- Filter Form -->
    <section class="bg-pink-500 py-7 mt-4">
        <div class="container mx-auto px-4">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <img src="{{ asset('image/brain.png') }}" class="w-20 h-20">
                    <div>
                        <h2 class="text-3xl font-bold text-black">Why this Job and How to Get There?</h2>
                        <p class="text-sm text-black">Discover how your unique skills and interests align with this job role</p>
                        <p class="text-sm text-black">and learn the step-by-step path to achieve your aspirations </p>
                    </div>
                </div>
        </div>
    </section>

  <!-- Main Content Container -->
  <section class="max-w-5xl mx-auto mt-10 mb-20 px-4 space-y-8">

    @php
      // Prepare variables for the view. The route passes a `job` array or null.
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
    <div class="bg-white shadow-md rounded-xl p-6 border">
      <div class="flex justify-between items-start mb-4">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('image/nameofjob.png') }}" alt="Job Icon" class="w-8 h-8">
          <h3 class="text-xl font-semibold text-gray-800">{{ $jobTitle }}</h3>
          <button class="text-blue-600 hover:text-blue-800">🔊</button>
        </div>
        <div class="flex items-center gap-4">
          <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">{{ $matchPercent !== null ? ($matchPercent . '% Match for You') : 'Matched' }}</span>
          <span class="text-sm bg-green-200 text-green-700 px-3 py-1 rounded-full font-medium mt-1">{{ $matchPercent !== null && $matchPercent >= 75 ? 'Excellent Match' : ($matchPercent !== null && $matchPercent >= 50 ? 'Good Match' : 'Potential Match') }}</span>
        </div>
      </div>

      <!-- Why this Job Match -->
      <h4 class="text-lg font-semibold text-gray-800 mb-2">Why this Job Matches You</h4>
      @php $whySentence = $job['why_sentence'] ?? null; @endphp
      @if($whySentence)
        <div class="text-sm text-gray-700 italic mb-3">{{ $whySentence }}</div>
      @endif
      <div class="text-sm text-gray-700 mb-3">
        @if($jobDescription)
          <p>{{ $jobDescription }}</p>
        @else
          <p>This job was recommended because it aligns with your skills and preferences.</p>
        @endif
      </div>
      <ul class="list-disc ml-6 text-sm space-y-3">
        @if(!empty($jobSkills))
          @foreach(array_slice($jobSkills,0,6) as $s)
            <li>{{ $s }} <span class="block text-gray-500 italic text-xs">(This skill matches your profile)</span></li>
          @endforeach
        @else
          <li>We didn't find explicit required skills in the job listing — the recommendation algorithm matched this job based on related skills and interests.</li>
        @endif
      </ul>
    </div>

    <!-- What is this Job Card -->
    <div class="bg-white shadow-md rounded-xl p-6 border">
      <div class="flex items-center mb-3 space-x-2">
        <img src="{{ asset('image/whatisthisjob.png') }}" alt="Info" class="w-6 h-6">
        <h4 class="text-lg font-semibold text-gray-800">What is this Job?</h4>
        <span class="text-sm text-gray-500 italic">(Ano ang Trabahong Ito?)</span>
        <button class="text-blue-600 hover:text-blue-800">🔊</button>
      </div>

      <p class="text-sm text-gray-700 mb-2">
        A Kitchen Helper works in a restaurant kitchen to keep everything clean, organized, and running smoothly!
      </p>
      <p class="text-xs italic text-gray-500 mb-4">(Ang Katulong sa Kusina ay nagtatrabaho sa kusina ng restawran upang mapanatiling malinis, maayos, at maayos ang takbo ng lahat.)</p>

      <p class="text-sm text-gray-700">
        This is a perfect job if you like working with your hands, following clear steps, and being part of a busy team. You’ll work in a supportive environment where everyone helps each other, and you’ll learn new skills every day.
      </p>
      <p class="text-xs italic text-gray-500">
        (Ito ay perpektong trabaho kung mahilig kang gumamit ng iyong mga kamay, sumusunod sa malinaw na mga hakbang, at gustong maging bahagi ng isang abalang grupo. Magtatrabaho ka sa isang lugar kung saan lahat ay nagtutulungan, at matututo ka ng mga bagong kasanayan araw-araw.)
      </p>
    </div>

    <!-- Possible You will do this Job Card -->
    <div class="bg-white shadow-md rounded-xl p-6 border">
      <div class="flex items-center mb-3 space-x-2">
        <img src="{{ asset('image/checkmark.png') }}" alt="Check" class="w-6 h-6">
        <h4 class="text-lg font-semibold text-gray-800">Possible You will do this Job</h4>
        <span class="text-sm text-gray-500 italic">(Mga Posibleng Gawin sa Trabahong Ito)</span>
        <button class="text-blue-600 hover:text-blue-800">🔊</button>
      </div>

      <ul class="list-disc ml-6 text-sm space-y-3">
        <li>
          <span class="font-semibold">Wash Dishes and Utensils:</span> Clean pots, pans, plates, and cooking tools using a dishwasher and by hand.
          <span class="block text-gray-500 italic text-xs">(Hugasan ang Pinggan at Kagamitan: Linisin ang mga kaldero, kawali, plato, at mga gamit sa pagluluto gamit ang dishwasher at sa pamamagitan ng kamay.)</span>
        </li>
        <li>
          <span class="font-semibold">Prepare Simple Ingredients:</span> Wash, peel, and help get ingredients ready for cooking.
          <span class="block text-gray-500 italic text-xs">(Maghanda ng Simpleng Sangkap: Hugasan, balatan, at tumulong sa paghahanda ng mga sangkap para sa pagluluto.)</span>
        </li>
        <li>
          <span class="font-semibold">Keep Kitchen Clean:</span> Sweep and mop floors, wipe counters, and take out garbage to keep the kitchen sparkling clean.
          <span class="block text-gray-500 italic text-xs">(Panatilihing Malinis ang Kusina: Walisin at mopahin ang sahig, punasan ang counter, at itapon ang basura upang manatiling maaliwalas at malinis ang kusina.)</span>
        </li>
        <li>
          <span class="font-semibold">Organize Supplies:</span> Put away clean dishes, stock shelves, and help keep storage areas neat and organized.
          <span class="block text-gray-500 italic text-xs">(Ayusin ang mga Supply: Ibalik ang malilinis na pinggan, lagyan ng laman ang mga estante, at tumulong na panatilihing maayos at organisado ang mga lugar ng imbakan.)</span>
        </li>
        <li>
          <span class="font-semibold">Help the Cooks:</span> Bring ingredients to the cooks when they need them and help with simple food prepare tasks.
          <span class="block text-gray-500 italic text-xs">(Tumulong sa mga Cook: Dalhin ang mga sangkap sa mga cook kapag kailangan nila at tumulong sa mga simpleng gawain sa paghahanda ng pagkain.)</span>
        </li>
      </ul>

      <!-- Illustrations -->
      <div class="flex justify-center gap-4 mt-6 flex-wrap">
        <img src="{{ asset('image/kitchenwork1.png') }}" alt="Kitchen Work 1" class="w-40 rounded-lg border">
        <img src="{{ asset('image/kitchenwork2.png') }}" alt="Kitchen Work 2" class="w-40 rounded-lg border">
        <img src="{{ asset('image/kitchenwork3.png') }}" alt="Kitchen Work 3" class="w-40 rounded-lg border">
        <img src="{{ asset('image/kitchenwork4.png') }}" alt="Kitchen Work 4" class="w-40 rounded-lg border">
      </div>
    </div>
  </section>
</div>

<script type="module">
  (async function(){
    try {
      const mod = await import('/js/job-application-firebase.js');
      try { await mod.ensureInit?.(); } catch(e){}
      try { await mod.signInWithServerToken("{{ route('firebase.token') }}"); } catch(e) { /* ignore */ }
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