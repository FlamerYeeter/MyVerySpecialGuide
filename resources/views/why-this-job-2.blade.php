@extends('layouts.includes')

@section('content')

<div class="font-sans bg-white text-gray-800">

  <!-- HEADER BANNER: NOTE AAYUSIN KO PA MAMAYA -->
    <br>
  <section class="bg-pink-500 flex flex-col md:flex-row items-center justify-center py-10 text-center md:text-left">
    <img src="/images/target-icon.png" alt="Goals Icon" class="h-24 mx-auto md:mx-8">
    <div>
      <h2 class="text-3xl font-bold text-black">Why this Job?</h2>
      <p class="text-gray-700">Discover how your unique skills and interests align with this job role</p>
      <p class="text-gray-700">and learn the step-by-step path to achieve your aspirations</p>
    </div>
  </section>

  <!-- Main Content Container -->
  <section class="max-w-5xl mx-auto mt-10 mb-20 px-4 space-y-8">

    <!-- Kitchen Helper Card -->
    <div class="bg-white shadow-md rounded-xl p-6 border">
      <div class="flex justify-between items-start mb-4">
        <div class="flex items-center space-x-3">
          <img src="/images/job-icon.png" alt="Job Icon" class="w-8 h-8">
          <h3 class="text-xl font-semibold text-gray-800">Kitchen Helper</h3>
        </div>
        <div class="flex items-center gap-4">
          <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">90% Match for You</span>
          <span class="text-sm bg-green-200 text-green-700 px-3 py-1 rounded-full font-medium mt-1">Excellent Match</span>
        </div>
      </div>

      <!-- Why this Job Match -->
      <h4 class="text-lg font-semibold text-gray-800 mb-2">Why this Job Match You?</h4>
      <ul class="list-disc ml-6 text-sm space-y-3">
        <li>
          You enjoy working with others and being helpful. In a kitchen, everyone works together as a team. You’ll support the cooks, help your coworkers when they’re busy, and be an important part of making the restaurant run smoothly.
          <span class="block text-gray-500 italic text-xs">(Mahilig kang makipagtulungan at tumulong sa iba. Sa kusina, lahat ay nagtutulungan bilang isang team. Tutulungan mo ang mga cook at magiging mahalagang bahagi ka sa pagpapatakbo ng restawran nang maayos.)</span>
        </li>
        <li>
          You work best when tasks are clear and organized. Kitchen work follows specific routines and checklists every day — wash these dishes, prep these vegetables, clean these areas. You’ll know exactly what to do and when to do it.
          <span class="block text-gray-500 italic text-xs">(Mas mahusay kang nagtatrabaho kapag malinaw at maayos ang mga gawain. Sa kusina, may tiyak na routine at listahan ng mga gagawin araw-araw, malalaman mo nang eksakto kung ano ang gagawin at kailan ito gagawin.)</span>
        </li>
      </ul>
    </div>

    <!-- What is this Job Card -->
    <div class="bg-white shadow-md rounded-xl p-6 border">
      <div class="flex items-center mb-3 space-x-2">
        <img src="/images/info-icon.png" alt="Info" class="w-6 h-6">
        <h4 class="text-lg font-semibold text-gray-800">What is this Job?</h4>
        <span class="text-sm text-gray-500 italic">(Ano ang Trabahong Ito?)</span>
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
        <img src="/images/check-icon.png" alt="Check" class="w-6 h-6">
        <h4 class="text-lg font-semibold text-gray-800">Possible You will do this Job</h4>
        <span class="text-sm text-gray-500 italic">(Mga Posibleng Gawin sa Trabahong Ito)</span>
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
        <img src="/images/kitchen1.png" alt="Kitchen Work 1" class="w-40 rounded-lg border">
        <img src="/images/kitchen2.png" alt="Kitchen Work 2" class="w-40 rounded-lg border">
        <img src="/images/kitchen3.png" alt="Kitchen Work 3" class="w-40 rounded-lg border">
        <img src="/images/kitchen4.png" alt="Kitchen Work 4" class="w-40 rounded-lg border">
      </div>
    </div>
  </section>
</div>

@endsection