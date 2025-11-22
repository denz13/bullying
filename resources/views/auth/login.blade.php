<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login | {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

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

        {{-- Livewire removed --}}
    </head>
    <body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-rose-50 text-gray-900 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 dark:text-gray-100 antialiased">
        <div class="absolute inset-0 pointer-events-none [mask-image:radial-gradient(circle_at_top,_white,_transparent_65%)] bg-[radial-gradient(circle_at_top,_rgba(79,70,229,0.25),_transparent_50%)] dark:bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.2),_transparent_55%)]"></div>

        <div class="relative min-h-screen flex flex-col items-center justify-center px-6 py-12">
            <div class="w-full max-w-lg">
                <div class="text-center mb-8 space-y-2">
                    <a href="{{ url('/') }}" class="inline-flex items-center justify-center text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                        {{ config('app.name') }}
                    </a>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Sign in to continue</p>
                </div>

                <div class="bg-white/95 dark:bg-gray-900/95 border border-white/60 dark:border-gray-800 shadow-2xl shadow-indigo-500/10 backdrop-blur rounded-3xl p-10 space-y-8">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-[0.3em] text-indigo-500">Secure portal</p>
                        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Login</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Please enter your credentials.</p>
                    </div>

                    <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Password
                            </label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                            <label class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                Remember me
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 hover:from-indigo-500 hover:to-violet-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Sign in
                            </button>
                            <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                                By continuing you agree to our terms and privacy policy.
                            </p>
                        </div>
                    </form>

                    @if (Route::has('register'))
                        <div class="text-sm text-center text-gray-600 dark:text-gray-400">
                            Need an account?
                            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                                Register
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Livewire removed --}}
    </body>
</html>
