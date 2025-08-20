<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Forgot Password | TripMe.lk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 md:bg-none bg-[url('https://images.unsplash.com/photo-1508672019048-805c876b67e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1368&q=80')] bg-cover bg-center">
   <div class="min-h-screen flex flex-col items-center justify-center bg-white/90 md:bg-transparent">
         <div class="grid md:grid-cols-[60%,40%] items-stretch w-full h-screen md:h-screen">

            <div class="hidden md:block h-full overflow-hidden  shadow-lg relative max-h-screen">
                <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                    loading="lazy" class="w-full h-full object-cover" alt="Mountain landscape" />

                <div class="absolute bottom-0 left-0 px-8 pb-8">
                    <h3 class="text-2xl font-bold text-white">Rediscover Your Journey</h3>
                    <p class="text-white/90 mt-2">Reset your password and continue your adventure</p>
                </div>
            </div>

            <div class="w-full px-10 py-8 bg-white rounded-none md:rounded-r-xl shadow-lg flex flex-col justify-center">
                {{-- <form action="{{ route('password.email') }}" method="POST"> --}}
                     <form action="" method="POST">
                    @csrf
                    <div class="flex flex-col gap-6 items-center">

                        <div class="flex items-center gap-2">
                            <img src="/images/logo.png" alt="TripMe Logo" class="h-16">
                        </div>

                        <h2 class="text-2xl font-bold text-gray-800">
                            Reset Your <span class="text-[#ff6c54]">Password</span>
                        </h2>
                        <p class="text-gray-500 text-center text-sm">Enter your email address and we'll send you a link to reset your password.</p>
                    </div>

                    <!-- Success Messages -->
                    @if (session('status'))
                        <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                            <p class="text-sm">{{ session('status') }}</p>
                        </div>
                    @endif

                    <div class="flex flex-col gap-6 mt-8">

                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-medium text-gray-700">Email address</label>
                            <input name="email" type="email" required value="{{ old('email') }}"
                                class="w-full px-4 py-2 border text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ff6c54] focus:border-[#ff6c54] outline-none transition"
                                placeholder="Enter your email" />
                        </div>

                        <button id="send-btn" type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-[#ff6c54] hover:bg-black text-white font-medium rounded-lg transition duration-200 disabled:opacity-70 disabled:cursor-not-allowed">
                            <svg id="send-loader" class="hidden w-5 h-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span id="send-text">Send Reset Link</span>
                        </button>

                        <div class="text-center text-sm text-gray-500">
                            Remember your password? <a href=""
                               {{-- Remember your password? <a href="{{ route('login') }}" --}}
                                class="text-[#ff6c54] hover:black font-medium">Back to login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border border-[#ff6c54]"
            role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15 5 11.586a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('status') }}</div>
            <button type="button" class="ml-auto text-gray-400 hover:text-gray-900" data-dismiss-target="#toast-success" aria-label="Close">✖</button>
        </div>
    @endif

    @if ($errors->any())
        <div id="toast-danger" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg border border-[#ff6c54]"
            role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5a1 1 0 10-2 0v2a1 1 0 002 0zm0 8a1 1 0 10-2 0v-4a1 1 0 102 0v4z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3 text-sm font-normal">{{ $errors->first() }}</div>
            <button type="button" class="ml-auto text-gray-400 hover:text-gray-900" data-dismiss-target="#toast-danger" aria-label="Close">✖</button>
        </div>
    @endif

    <script>
        // Auto-dismiss toasts after 4 seconds
        setTimeout(() => {
            document.querySelectorAll('[id^="toast-"]').forEach(el => el.remove());
        }, 4000);
        
        // Form submission handler
        const sendBtn = document.getElementById('send-btn');
        const sendLoader = document.getElementById('send-loader');
        const sendText = document.getElementById('send-text');
        const resetForm = document.querySelector('form');

        resetForm.addEventListener('submit', function (e) {
            e.preventDefault(); 

            sendBtn.disabled = true;
            sendLoader.classList.remove('hidden');
            sendText.textContent = "Sending...";

            setTimeout(() => {
                resetForm.submit(); 
            }, 500);
        });
    </script>
</body>

</html>