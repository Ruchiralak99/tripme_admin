<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | TripMe.lk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center">
                        <img src="/images/logo.png" alt="TripMe Logo" class="h-10">
                        <span class="ml-2 text-xl font-bold text-gray-800">TripMe Dashboard</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, {{ Auth::user()->first_name }}!</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Success Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg p-8">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">Welcome to TripMe Dashboard</h1>
                        <p class="text-lg text-gray-600 mb-8">Your travel management system</p>

                        <!-- User Info Card -->
                        <div class="bg-white shadow-lg rounded-lg p-6 max-w-md mx-auto">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Profile</h2>
                            <div class="space-y-2 text-left">
                                <p><strong>Name:</strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                <p><strong>Role:</strong> {{ ucfirst(Auth::user()->role) }}</p>
                                @if(Auth::user()->business_name)
                                    <p><strong>Business:</strong> {{ Auth::user()->business_name }}</p>
                                @endif
                                @if(Auth::user()->vendor_type)
                                    <p><strong>Vendor Type:</strong> {{ Auth::user()->vendor_type }}</p>
                                @endif
                                @if(Auth::user()->contact_number)
                                    <p><strong>Phone:</strong> {{ Auth::user()->contact_number }}</p>
                                @endif
                                <p><strong>Member Since:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</p>
                                @if(Auth::user()->last_login_at)
                                    <p><strong>Last Login:</strong> {{ Auth::user()->last_login_at->format('M d, Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
