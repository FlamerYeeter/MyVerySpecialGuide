<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Registration: Review Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Floating animations */
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }
      .animate-float-slow { animation: float 5s ease-in-out infinite; }
      .animate-float-medium { animation: float 3.5s ease-in-out infinite; }
      .animate-float-fast { animation: float 2.5s ease-in-out infinite; }

      .selectable-card { border: 2px solid transparent; transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
      .selectable-card.selected { border-color: #2563eb; box-shadow: 0 10px 30px rgba(37,99,235,0.14); transform: translateY(-6px); }
    </style>
  </head>

  <body class="bg-white flex justify-center items-center min-h-screen p-4 relative overflow-auto">

    <!-- Floating Mascots -->
    <img src="image/obj4.png" alt="Yellow Mascot"
      class="fixed left-2 sm:left-6 lg:left-8 top-1/3 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-slow z-0" />
    <img src="image/obj7.png" alt="Triangle Mascot"
      class="fixed left-2 sm:left-6 lg:left-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0" />
    <img src="image/obj3.png" alt="Blue Mascot"
      class="fixed right-2 sm:right-6 lg:right-8 top-1/4 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-fast z-0" />
    <img src="image/obj8.png" alt="Twin Mascot"
      class="fixed right-2 sm:right-6 lg:right-8 bottom-20 sm:bottom-24 lg:bottom-28 w-20 sm:w-28 lg:w-36 opacity-90 animate-float-medium z-0" />

    <!-- Back Button -->
    <button
      class="absolute left-3 sm:left-6 top-4 sm:top-6 bg-blue-500 text-white px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg flex items-center justify-center gap-2 text-center hover:bg-blue-600 transition z-10 shadow-md active:scale-95"
      onclick="window.location.href='{{ route('registerreview2') }}'">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="4" stroke="white" class="w-4 sm:w-5 h-4 sm:h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="text-base sm:text-lg font-medium">Back</span>
    </button>

    <!-- Main Container -->
    <div class="bg-yellow-100 max-w-3xl w-full rounded-2xl shadow-lg p-8 relative z-10">

      <!-- Header -->
      <div class="mt-4 flex flex-col items-start text-left max-w-xl mx-auto">
        <h2 class="text-xl font-semibold text-blue-500 flex items-center gap-2 border-b-2 border-blue-500 pb-1 w-full">
          Review Your Qualifications
          <span class="text-gray-600 italic text-base">(Suriin ang Iyong Kwalipikasyon)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform translate-y-[-2px]">🔊</button>
        </h2>

        <!-- Support I Need Information Section -->
        <h2 class="text-lg font-semibold mt-8">
          Support I Need
          <span class="text-gray-600 italic text-base">(Suporta na Kailangan ko)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </h2>
        <p class="mt-2">Selected support: <span id="review_support_choice">—</span></p>
      </div>

      <!-- Support I Need Information Form -->
      <form class="mt-6 max-w-xl mx-auto">
        <label class="font-semibold text-[15px] flex items-center gap-1">
          What kind of support would help you at work?
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </label>
        <p class="mt-2 text-gray-500 italic text-[14px]">(Ano klaseng tulong ang makakatulong sa iyo sa trabaho?)</p>
        <p class="font-semibold text-black-500 text-[15px] mt-8">
          The picture below is your answer.
          <span class="italic text-gray-500">(Ang picture sa baba ay ang iyong sagot)</span>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </p>

        <!-- Support need answer -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
          <div class="bg-white p-4 rounded-xl shadow h-[340px] relative border-2 border-blue-500 selectable-card">
            <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <img src="image/support1.png" alt="job coach" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Job coach/guide to guide me</h3>
          </div>
          
          <div class="bg-white p-4 rounded-xl shadow h-[340px] relative border-2 border-blue-500 selectable-card">
            <button type="button" class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow">🔊</button>
            <img src="image/support2.png" alt="written instruction" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">Written instructions</h3>
          </div> 
        </div>

        <!-- Edit Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang “Support I Need Information” upang baguhin ang iyong sagot)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            ✏️ Click to Support I Need Information
          </button>
        </div>
      </form>

      <!-- Work Environment Information Section -->
      <div class="mt-12 max-w-xl mx-auto">
        <h2 class="text-lg font-semibold">
          Work Environment
          <span class="text-gray-600 italic text-base">(Kapaligiran sa Trabaho)</span>
          <button class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </h2>

        <label class="font-semibold text-[15px] flex items-center gap-1 mt-6">
          What kind of working environment feels comfortable for you? 
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </label>
        <p class="mt-2 text-gray-500 italic text-[14px]">(Ano klaseng lugar ng trabaho ang komportable para sa iyo? Piliin lahat ng naaangkop na 
            kakayahan na meron ka)
        </p>

        <p class="font-semibold text-black-500 text-[15px] mt-8">
          The picture below is your answer.
          <span class="italic text-gray-500">(Ang picture sa baba ay ang iyong sagot)</span>
          <button type="button" class="text-gray-500 text-xl leading-none hover:scale-110 transition-transform">🔊</button>
        </p>
        <p class="mt-2">Selected workplace: <span id="review_workplace_choice">—</span></p>

        <!-- Work Environment answer -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
          <div class="bg-white p-4 rounded-xl shadow h-[400px] relative border-2 border-blue-500 selectable-card">
            <button class="absolute top-3 right-3 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow transition">🔊</button>
            <img src="image/workplc1.png" alt="quietplace" class="w-full rounded-md mb-4">
            <h3 class="text-blue-600 font-semibold text-center">The place is quiet and calm</h3>
            <p class="mt-2 text-[13px] text-gray-500 italic text-center">(Tahimik at kalmado ang lugar)</p>
          </div>
        </div>

        <!-- Edit Button -->
        <div class="flex flex-col items-start mt-8">
          <p class="text-gray-500 italic text-[13px] mb-2 text-left">
            (Pindutin ang “Edit Work Environment” upang baguhin ang iyong sagot)
          </p>
          <button type="button"
            class="bg-blue-500 text-white font-semibold text-lg px-8 sm:px-12 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2 justify-center w-full mx-auto shadow-md">
            ✏️ Click to Edit Work Environment
          </button>
        </div>

        <!-- Info Box -->
        <div class="bg-green-50 border border-green-400 rounded-lg px-5 py-4 mt-6 shadow-sm">
          <div class="flex items-start gap-2">
            <p class="text-[14px] text-black-800 leading-relaxed">
              This information will help us find workplaces where you will feel comfortable and supported.
            </p>
            <button type="button" class="text-green-600 text-xl leading-none hover:text-green-700 hover:scale-110 transition-transform mt-[2px]" title="Play Audio">🔊</button>
          </div>
          <p class="mt-2 italic text-gray-700 text-[13px] leading-relaxed">
            (Ang impormasyong ito ay makakatulong sa amin na makahanap ng mga lugar ng trabaho kung saan ka magiging
            komportable at supporta.)
          </p>
        </div>
      </div>

      <!-- Continue Button -->
      <div class="text-center mt-12">
        <button type="button"
          class="bg-blue-500 text-white font-semibold text-lg px-24 py-3 rounded-xl hover:bg-blue-600 transition flex items-center gap-2"
          onclick="window.location.href='{{ route('registerreview4') }}'">
          Continue →
        </button>
        <p class="text-gray-700 text-sm mt-3">
          Click <span class="text-blue-500 font-medium">“Continue”</span> to move to the next page
        <p class="text-gray-500 italic text-[13px]">(Pindutin ang “Continue” upang magpatuloy)</p>
      </div>

    </div>

    <script src="{{ asset('js/register.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', async function () {
        if (!window.firebase || !window.firebase.auth || !window.firebase.firestore) return;
        try {
          const auth = firebase.auth();
          const db = firebase.firestore();
          let user = auth.currentUser;
          if (!user) user = await new Promise(res => firebase.auth().onAuthStateChanged(res));
          if (!user) return;
          const doc = await db.collection('users').doc(user.uid).get();
          if (!doc.exists) return;
          const data = doc.data();
          // Support Need
          if (data.supportNeed) {
            document.getElementById('review_support_choice').textContent = data.supportNeed.support_type || '';
          }
          // Workplace
          if (data.workplace) {
            document.getElementById('review_workplace_choice').textContent = data.workplace.workplace_type || '';
          }
        } catch (e) { console.warn('Preview load failed', e); }
      });
    </script>
  </body>
</html>
