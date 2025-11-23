<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Immaculate Conception School of Naic - Guidance Office' }}</title>
        <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
            <script>
                tailwind.config = {
                    darkMode: 'class',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['"Instrument Sans"', 'ui-sans-serif', 'system-ui'],
                            },
                            colors: {
                                brand: {
                                    DEFAULT: '#4f46e5',
                                    accent: '#f43f5e',
                                },
                            },
                        },
                    },
                };
            </script>
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @endif

        <style>[x-cloak]{display:none !important;}</style>

        @stack('head')
        <script src="{{ asset('js/action-center/action-center.js') }}"></script>
    </head>
    @php
        use App\Models\notification;
        $unreadNotifications = auth()->check() 
            ? notification::where('status', 'unread')
                ->orderBy('created_at', 'desc')
                ->get()
            : collect();
    @endphp

    <body x-data="{ mobileNav: false }" class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 antialiased font-sans overflow-x-hidden">
        <div id="toast-container" class="fixed top-6 right-6 z-[10001] space-y-4 max-w-md">
            @foreach($unreadNotifications as $notification)
                @php
                    $type = 'info';
                    if ($notification->notification_type === 'Request Counseling') {
                        $type = 'info';
                    } elseif ($notification->notification_type === 'Share Experience') {
                        $type = 'warning';
                    }
                @endphp
                <div
                    x-data="{ visible: true, notificationId: {{ $notification->id }} }"
                    x-show="visible"
                    x-transition
                    class="mb-4 opacity-0 translate-x-full transition-all duration-300"
                    data-notification-id="{{ $notification->id }}"
                >
                    <x-notification-toast
                        :id="'notification-' . $notification->id"
                        :type="$type"
                        :title="$notification->notification_type"
                        :message="$notification->content"
                        :show="true"
                    />
                </div>
            @endforeach
        </div>
        
        <div class="min-h-screen flex overflow-x-hidden">
            @include('layouts.sidebar')

            @include('layouts.mobile')

            <div class="flex-1 flex flex-col min-h-screen min-w-0 overflow-x-hidden">
                @include('layouts.topbar')

                <main class="flex-1 w-full min-w-0 overflow-x-hidden">
                    @yield('content')
                </main>
            </div>
        </div>

        @stack('scripts')

        <script src="{{ asset('js/action-center/action-center.js') }}"></script>
        @include('action-center.action-center')
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Only target toast notifications in the toast-container, not the dropdown
                const toastContainer = document.getElementById('toast-container');
                if (!toastContainer) return;
                
                const notifications = toastContainer.querySelectorAll('[data-notification-id]');
                notifications.forEach((notification, index) => {
                    setTimeout(() => {
                        notification.classList.remove('opacity-0', 'translate-x-full');
                        notification.classList.add('opacity-100', 'translate-x-0');
                    }, index * 100);
                });
                
                // Auto-remove toast notifications after 5 seconds (without marking as read)
                notifications.forEach((notification) => {
                    const closeBtn = notification.querySelector('button[x-on\\:click]');
                    
                    if (closeBtn) {
                        closeBtn.addEventListener('click', () => {
                            // Just remove the notification, don't mark as read
                            notification.classList.remove('opacity-100', 'translate-x-0');
                            notification.classList.add('opacity-0', 'translate-x-full');
                            setTimeout(() => {
                                if (notification.parentNode) {
                                    notification.parentNode.removeChild(notification);
                                }
                            }, 300);
                        });
                    }
                    
                    // Auto-remove after 5 seconds (without marking as read)
                    setTimeout(() => {
                        notification.classList.remove('opacity-100', 'translate-x-0');
                        notification.classList.add('opacity-0', 'translate-x-full');
                        setTimeout(() => {
                            if (notification.parentNode) {
                                notification.parentNode.removeChild(notification);
                            }
                        }, 300);
                    }, 5000);
                });
            });
        </script>
    </body>
</html>
