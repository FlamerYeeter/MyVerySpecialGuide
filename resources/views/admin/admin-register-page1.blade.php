{{--Will move to the admin folder tas route niyo ng maayos yan Thomas--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create An Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#ffffff] flex justify-center items-center min-h-screen">

    <div class="bg-[#fff2c7] w-full max-w-3xl rounded-3xl p-10 shadow-md relative">
        <!-- Step indicator -->
        <p class="text-sm text-black absolute top-6 right-8">Step 1 out of 2</p>

        <!-- Title -->
        <h1 class="text-2xl text-center font-semibold text-black mb-2">Create An Account</h1>

        <!-- Mascot Image (replace src if needed) -->
        <div class="flex justify-center mb-6">
            <img src="image/obj6.png" alt="Mascot" class="w-16 h-16">
        </div>

        <!-- Subtitle -->
        <p class="text-[#2aa6f7] font-semibold mb-1">For Admin Approval</p>
        <p class="text-sm text-black mb-8">Please type your information inside the box.</p>

        <!-- Form -->
        <form class="space-y-4">
            <!-- Name Fields -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-black mb-1">Full Name<span class="text-red-500">*</span></label>
                        <input id="name" name="name" type="text" placeholder="Full name"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-[#fffaf7] focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-1">Username<span class="text-red-500">*</span></label>
                        <input id="username" name="username" type="text" placeholder="Username"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-[#fffaf7] focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>

            <!-- Email Field -->
                <div>
                    <label class="block text-sm font-medium text-black mb-1">Email Address<span class="text-red-500">*</span></label>
                    <input id="email" name="email" type="email" placeholder="Email Address"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 bg-[#fffaf7] focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

            <!-- Upload Section -->
            <div class="bg-[#fff2c7] rounded-md p-4">
                <label class="block text-sm font-medium text-black mb-1">
                    Upload Authorized Organization Letter<span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-[#2aa6f7] mb-2">
                    Please note: When uploading your authorization letter, it must be duly signed by your organization’s authorized signatory to confirm that you are an official and approved to be an admin.
                </p>
                <div class="flex justify-between items-center bg-[#e0edf6] p-3 rounded-md">
                    <span class="text-sm text-black">Upload Proof (JPG, PNG, or PDF)</span>
                    <label class="bg-[#4638ff] hover:bg-[#362ecc] text-white px-4 py-2 rounded-md cursor-pointer text-sm">
                        <input type="file" hidden> Choose File
                    </label>
                </div>
            </div>

            <!-- Info -->
            <p class="text-[#2aa6f7] text-sm">Click to Submit for Approval</p>

            <!-- Submit Button -->
            <button id="submitBtn" type="button" class="bg-[#41aef5] hover:bg-[#2a9ce3] text-white font-semibold w-full py-3 rounded-md mt-1">
                Submit for Approval
            </button>

            <!-- Instructions -->
            <div class="text-center mt-4">
                <p class="text-sm text-black">
                    Check your email inbox for the approval confirmation message to proceed to the next step.
                </p>
                <p class="text-sm text-gray-700 mt-3">
                    Didn’t receive confirmation? Click 
                    <a href="#" class="text-[#2aa6f7] font-semibold hover:underline">Resend</a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('submitBtn');
        if (!btn) return;
        btn.addEventListener('click', async function() {
            btn.disabled = true; btn.classList.add('opacity-60');
            const name = document.getElementById('name')?.value || '';
            const email = document.getElementById('email')?.value || '';
            const username = document.getElementById('username')?.value || '';

            const payload = { name: name, email: email, username: username };

            try {
                const resp = await fetch('{{ route('admin.register.submit') }}', {
                    method: 'POST',
                    credentials: 'same-origin', // include cookies so Laravel session & CSRF are valid
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload),
                });

                // Try to parse JSON if the server returned JSON, otherwise show the text body (HTML error page)
                const contentType = resp.headers.get('content-type') || '';
                let data = null;
                if (contentType.indexOf('application/json') !== -1) {
                    data = await resp.json();
                } else {
                    const text = await resp.text();
                    // show helpful debug message when server returned HTML (unexpected)
                    alert('Registration error: ' + (text.slice(0, 200) || 'server returned non-JSON response'));
                    console.error('server non-json response', resp.status, text);
                    return;
                }

                if (data && data.ok) {
                    // redirect to provided URL or admin dashboard
                    window.location.href = data.redirect || '/admin/approval';
                    return;
                }
                console.warn('registration failed', data);
                alert('Registration failed: ' + (data.error || (data.errors ? JSON.stringify(data.errors) : 'unknown')));
            } catch (err) {
                console.error('registration exception', err);
                alert('Registration error: ' + err.message);
            } finally {
                btn.disabled = false; btn.classList.remove('opacity-60');
            }
        });
    });
    </script>
