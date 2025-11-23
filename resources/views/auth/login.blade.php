<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login | Immaculate Conception School of Naic - Guidance Office</title>
        <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
            <script>
                tailwind.config = {
                    darkMode: 'class',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['"Instrument Sans"', 'ui-sans-serif', 'system-ui'],
                            },
                        },
                    },
                };
            </script>
        @endif
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900 antialiased font-sans overflow-x-hidden">
        <div class="min-h-screen flex">
            <!-- Left Panel - Logo -->
            <div class="hidden lg:flex lg:w-1/2 bg-white items-center justify-center p-12 relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-20 left-20 w-64 h-64 bg-blue-500 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-20 right-20 w-96 h-96 bg-indigo-500 rounded-full blur-3xl"></div>
                </div>
                
                <div class="relative z-10 flex flex-col items-center justify-center space-y-8">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="inline-flex items-center justify-center">
                        <img src="{{ asset('image/logo.png') }}" alt="{{ config('app.name') }}" class="h-64 w-64 object-contain" style="padding: 8px;">
                    </a>
                    <!-- Text below logo -->
                    <div class="text-center px-8 space-y-2">
                        <p class="text-2xl font-extrabold text-gray-900 leading-relaxed">
                            <strong>Official Website ng Immaculate Conception School of Naic</strong>
                        </p>
                        <p class="text-3xl font-extrabold text-blue-700 tracking-wide">
                            Guidance Office
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12 relative overflow-hidden" style="background-color: #1a4b84;">
                <!-- Decorative circle -->
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mb-48"></div>
                
                <div class="relative z-10 w-full max-w-md">
                    <!-- White Card -->
                    <div class="bg-white rounded-2xl shadow-2xl p-8 lg:p-10 space-y-6">
                        <!-- Header -->
                        <div class="space-y-2">
                            <h1 class="text-3xl font-bold text-gray-900">Hello!</h1>
                            <p class="text-gray-600">Sign In to Get Started</p>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
                            @csrf

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus
                                        placeholder="Enter your email"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400"
                                    >
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        required
                                        placeholder="Enter your password"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400"
                                    >
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Remember me
                                </label>
                            </div>

                            <!-- Login Button -->
                            <button
                                type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                Login
                            </button>
                        </form>

                        <!-- Forgot Password Link -->
                        <div class="text-left">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <!-- Register Link -->
                        @if (Route::has('register'))
                            <div class="text-center pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-600">
                                    Need an account?
                                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                        Register
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
