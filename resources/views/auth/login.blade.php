<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login | TripMe.lk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body
    class="bg-gray-50 md:bg-none bg-[url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1368&q=80')] bg-cover bg-center">
    <div class="max-h-screen flex flex-col items-center justify-center bg-white/80 md:bg-transparent">
        <div class="grid md:grid-cols-[60%,40%] items-stretch gap-0 w-full h-screen md:h-auto">

            <div class="hidden md:block h-full overflow-hidden rounded-l-xl shadow-lg relative max-h-screen">
                <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1368&q=80"
                    loading="lazy" class="w-full h-full object-cover" alt="Travel landscape" />

                <div class="absolute bottom-0 left-0 px-8 pb-8">
                    <h3 class="text-2xl font-bold text-white">Discover Sri Lanka with Us</h3>
                    <p class="text-white/90 mt-2">Your perfect travel experience starts here</p>
                </div>
            </div>

            <div class="w-full px-10 py-8 bg-white rounded-none md:rounded-r-xl shadow-lg flex flex-col justify-center">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-6 items-center">

                        <div class="flex items-center gap-2">
                            <img src="/images/logo.png" alt="TripMe Logo" class="h-16">
                        </div>

                        <h2 class="text-2xl font-bold text-gray-800">
                            Welcome back to <span class="text-[#ff6c54]">TripMe</span>
                        </h2>
                        <p class="text-gray-500 text-center text-sm">Sign in to access your travel dashboard and manage your
                            bookings.</p>
                    </div>

                    <!-- Error Messages -->
                    {{-- @if ($errors->any())
                        <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <!-- Success Messages -->
                    {{-- @if (session('success'))
                        <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    @endif --}}

                    <div class="flex flex-col gap-6 mt-8">

                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-medium text-gray-700">Email address</label>
                            <input name="email" type="email" required value="{{ old('email') }}"
                                class="w-full px-4 py-2 border text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                placeholder="Enter your email" />
                        </div>


                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between items-center">
                                <label class="text-sm font-medium text-gray-700">Password</label>
                            </div>
                            <div class="relative">
                                <input name="password" id="password" type="password" required
                                    class="w-full px-4 py-2 border text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                    placeholder="Enter your password" />
                                <button type="button" onclick="togglePasswordVisibility()"
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


                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 accent-[#ff6c54] focus:ring-[#ff6c54]">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>

                            </div>
                            <a href="#" class="text-sm text-gray-700 hover:text-[#ff6c54]">Forgot password?</a>
                        </div>

                    <button id="login-btn" type="submit"
    class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-[#ff6c54] hover:bg-black text-white font-medium rounded-lg transition duration-200 disabled:opacity-70 disabled:cursor-not-allowed">
    <svg id="login-loader" class="hidden w-5 h-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
    <span id="login-text">Sign in</span>
</button>



                        <div class="text-center text-sm text-gray-500">
                            Don't have an account? <a href="{{ route('register') }}"
                                class="text-[#ff6c54] hover:balck font-medium">Sign up</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    @if (session('success'))
        <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border border-[#ff6c54]"
            role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 5 11.586a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('success') }}</div>
            <button type="button" class="ml-auto text-gray-400 hover:text-gray-900" data-dismiss-target="#toast-success" aria-label="Close">✖</button>
        </div>
    @endif

    @if (session('error'))
        <div id="toast-danger" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border border-[#ff6c54]"
            role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5a1 1 0 10-2 0v2a1 1 0 002 0zm0 8a1 1 0 10-2 0v-4a1 1 0 102 0v4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('error') }}</div>
            <button type="button" class="ml-auto text-gray-400 hover:text-gray-900" data-dismiss-target="#toast-danger" aria-label="Close">✖</button>
        </div>
    @endif

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('button[onclick="togglePasswordVisibility()"] svg');

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

       
        setTimeout(() => {
            document.querySelectorAll('[id^="toast-"]').forEach(el => el.remove());
        }, 4000);
    </script>

    <script>
    const loginBtn = document.getElementById('login-btn');
    const loginLoader = document.getElementById('login-loader');
    const loginText = document.getElementById('login-text');
    const loginForm = document.querySelector('form');

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); 

        loginBtn.disabled = true;
        loginLoader.classList.remove('hidden');
        loginText.textContent = "Signing in...";

        setTimeout(() => {
            loginForm.submit(); 
        },500);
    });
</script>


    
</body>

</html>
