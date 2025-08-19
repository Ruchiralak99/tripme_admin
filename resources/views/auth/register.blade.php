<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Register | TripMe.lk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.2/flowbite.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 md:bg-none bg-[url('https://images.unsplash.com/photo-1508672019048-805c876b67e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1368&q=80')] bg-cover bg-center">
    <div class="min-h-screen flex flex-col items-center justify-center bg-white/90 md:bg-transparent">
        <div class="grid md:grid-cols-[60%,40%] items-stretch w-full h-screen md:h-screen">

         
            <div class="hidden md:block h-full overflow-hidden">
                <img src="https://images.unsplash.com/photo-1508672019048-805c876b67e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1368&q=80"
                     loading="lazy"
                     class="w-full h-full object-cover"
                     alt="Travel adventure" />
            </div>

          
            <div class="flex items-center justify-center h-full">
                <div class="w-full h-full flex items-center justify-center">
                    <div class="w-full px-8 py-8 bg-white shadow-lg h-full overflow-y-auto">
                        <form action="{{ route('register.post') }}" method="POST" id="registerForm">
                            @csrf
                            <div class="flex flex-col gap-6 items-center">

                                <div class="flex items-center gap-2">
                                    <img src="/images/logo.png" alt="TripMe Logo" class="h-16">
                                </div>

                                <h2 class="text-2xl font-bold text-gray-800">
                                    Join <span class="text-[#ff6c54]">TripMe</span>
                                </h2>
                                <p class="text-gray-500 text-center">Create your account to start your journey with us</p>
                            </div>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-sm">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Success Messages -->
                            @if (session('success'))
                                <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                                    <p class="text-sm">{{ session('success') }}</p>
                                </div>
                            @endif

                            <div class="flex flex-col gap-6 mt-8">

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex flex-col gap-2">
                                        <label class="text-sm font-medium text-gray-700">First Name</label>
                                        <input name="first_name" type="text" required value="{{ old('first_name') }}"
                                            class="w-full px-4 py-2  text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                            placeholder="First name" />
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-sm font-medium text-gray-700">Last Name</label>
                                        <input name="last_name" type="text" required value="{{ old('last_name') }}"
                                            class="w-full px-4 py-2 border text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                            placeholder="Last name" />
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-medium text-gray-700">Email</label>
                                    <input name="email" type="email" required value="{{ old('email') }}"
                                        class="w-full px-4 py-2 border text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                        placeholder="Enter your email" />
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-medium text-gray-700">Business Name</label>
                                    <input name="business_name" type="text" value="{{ old('business_name') }}"
                                        class="w-full px-4 py-2 border text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                        placeholder="Business name" />
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-medium text-gray-700">Phone</label>
                                    <input name="phone" type="tel" value="{{ old('phone') }}"
                                        class="w-full px-4 py-2 border text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                        placeholder="Phone number" />
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-medium text-gray-700">Password</label>
                                    <div class="relative">
                                        <input name="password" id="password" type="password" required
                                            class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                            placeholder="Enter your password" />
                                        <button type="button" onclick="togglePasswordVisibility('password')"
                                            class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters long.</p>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                                    <div class="relative">
                                        <input name="confirm_password" id="confirm_password" type="password" required
                                            class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                            placeholder="Confirm your password" />
                                        <button type="button" onclick="togglePasswordVisibility('confirm_password')"
                                            class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-medium py-2 text-gray-700">Select Your Partner Type</label>
                                    <div class="space-y-2 mt-2">
                                        <div class="flex items-center">
                                            <input id="affiliate" name="partner_type" type="radio" value="affiliate"
                                                {{ old('partner_type') == 'affiliate' ? 'checked' : '' }}
                                             class="h-4 w-4  accent-[#ff6c54] focus:ring-[#ff6c54]">
                                            <label for="affiliate" class="ml-2 block text-sm text-gray-700">Affiliate</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="vendor" name="partner_type" type="radio" value="vendor"
                                                {{ old('partner_type') == 'vendor' ? 'checked' : '' }}
                                              class="h-4 w-4  accent-[#ff6c54] focus:ring-[#ff6c54]">
                                            <label for="vendor" class="ml-2 block text-sm text-gray-700">Vendor</label>
                                        </div>
                                      
                                        <div id="vendorTypeContainer" class="mt-2"
                                            style="display:{{ old('partner_type') == 'vendor' ? 'block' : 'none' }};">
                                            <label for="vendor_type" class="text-sm mt-2 font-medium text-gray-700">Vendor Type</label>
                                            <select name="vendor_type" id="vendor_type"
                                                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition mt-1">
                                                <option value="">Select Vendor Type</option>
                                                <option value="Hotel Partner"
                                                    {{ old('vendor_type') == 'Hotel Partner' ? 'selected' : '' }}>Hotel Partner
                                                </option>
                                                <option value="Activity Partner"
                                                    {{ old('vendor_type') == 'Activity Partner' ? 'selected' : '' }}>Activity Partner
                                                </option>
                                                <option value="Travel Guide"
                                                    {{ old('vendor_type') == 'Travel Guide' ? 'selected' : '' }}>Travel Guide
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                              
                                <button type="submit" id="signupBtn"
                                    class="w-full py-3 px-4 bg-[#ff6c54] hover:bg-black text-white font-medium rounded-lg transition duration-200 flex items-center justify-center">
                                    <span id="btnText">Create Account</span>
                                    <svg id="btnLoader" aria-hidden="true" role="status"
                                        class="hidden ml-2 w-5 h-5 text-white animate-spin"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 000 16z"></path>
                                    </svg>
                                </button>

                                <div class="text-center text-sm text-gray-500">
                                    Already have an account? <a href="{{ route('login') }}"
                                        class="text-[#ff6c54] hover:text-black font-medium">Sign in</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

   
    <div id="toast-container" class="fixed top-5 right-5 space-y-3 z-50"></div>

  

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.querySelector(`button[onclick="togglePasswordVisibility('${fieldId}')"] svg`);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                `;
            }
        }

      
        document.addEventListener('DOMContentLoaded', function () {
            const vendorRadio = document.getElementById('vendor');
            const affiliateRadio = document.getElementById('affiliate');
            const vendorTypeContainer = document.getElementById('vendorTypeContainer');

            function toggleVendorType() {
                vendorTypeContainer.style.display = vendorRadio.checked ? 'block' : 'none';
            }

            vendorRadio.addEventListener('change', toggleVendorType);
            affiliateRadio.addEventListener('change', toggleVendorType);
        });

    
        const form = document.getElementById('registerForm');
        const signupBtn = document.getElementById('signupBtn');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            btnText.textContent = "Processing...";
            btnLoader.classList.remove("hidden");

            setTimeout(() => {
                form.submit(); 
            }, 2000);
        });

       
        function showToast(type, message) {
            const toastContainer = document.getElementById("toast-container");
            const toast = document.createElement("div");
            toast.className =
                `flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow ` +
                (type === "success"
                    ? "border-l-4 border-green-500"
                    : "border-l-4 border-red-500");

            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${
                    type === "success" ? "bg-green-100 text-green-500" : "bg-red-100 text-red-500"
                }">
                    ${type === "success"
                        ? `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8.25 8.25a1 1 0 01-1.414 0l-3.25-3.25a1 1 0 111.414-1.414L8 12.086l7.543-7.543a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>`
                        : `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V7h2v2h-2zm0 4v-2h2v2h-2z" clip-rule="evenodd"></path></svg>`}
                </div>
                <div class="ml-3 text-sm font-normal">${message}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 inline-flex h-8 w-8" onclick="this.parentElement.remove()">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            `;
            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 4000);
        }

        
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            showToast('success', "{{ session('success') }}");
        @endif

        @if(session('error'))
            showToast('error', "{{ session('error') }}");
        @endif
    });
</script>

</body>

</html>
