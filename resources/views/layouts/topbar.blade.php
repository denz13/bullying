@php
    use App\Models\notification;
    
    $user = auth()->user();
    $navItems = collect(config('navigation.primary', []));
    $currentRoute = request()->route()?->getName();
    $activeItem = $navItems->firstWhere('route', $currentRoute);

    $breadcrumbs = [
        [
            'label' => 'Home',
            'url' => route('dashboard'),
            'active' => $currentRoute === 'dashboard' || !$activeItem,
        ],
    ];

    if ($activeItem && $activeItem['route'] !== 'dashboard') {
        $breadcrumbs[] = [
            'label' => $activeItem['label'],
            'url' => $activeItem['route'] ? route($activeItem['route']) : ($activeItem['url'] ?? '#'),
            'active' => true,
        ];
    }
    
    // Fetch unread notifications
    $unreadNotifications = auth()->check() 
        ? notification::where('status', 'unread')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
        : collect();
    
    $unreadCount = $unreadNotifications->count();
@endphp

<header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-white shadow-[0_10px_30px_rgba(15,46,117,0.08)]">
    <div class="w-full px-6 py-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <button
                class="inline-flex lg:hidden items-center justify-center rounded-full border border-gray-200 p-2 text-gray-700"
                @click="mobileNav = true"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <nav class="flex items-center gap-2 text-sm text-gray-500">
                @foreach ($breadcrumbs as $index => $crumb)
                    <a
                        href="{{ $crumb['url'] }}"
                        class="{{ $crumb['active'] ? 'text-gray-900 font-semibold' : 'hover:text-gray-900' }}"
                    >
                        {{ $crumb['label'] }}
                    </a>
                    @if ($index !== count($breadcrumbs) - 1)
                        <span class="text-gray-300">•</span>
                    @endif
                @endforeach
            </nav>
        </div>

        <div
            class="flex items-center gap-3 text-sm"
            x-data="{ 
                profileOpen: false, 
                notifyOpen: false,
                csrfToken: document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '',
                markNotificationAsRead(notificationId, element) {
                    // Prevent multiple clicks
                    if (element.dataset.processing === 'true') {
                        return;
                    }
                    element.dataset.processing = 'true';
                    
                    fetch(`/notifications/${notificationId}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Fade out animation
                            element.style.opacity = '0.5';
                            element.style.transition = 'opacity 0.3s';
                            setTimeout(() => {
                                element.remove();
                                // Update count without full reload
                                const remainingNotifications = document.querySelectorAll('[data-notification-id]');
                                if (remainingNotifications.length === 0) {
                                    window.location.reload();
                                } else {
                                    // Just update the badge count
                                    const badge = document.querySelector('.notification-badge');
                                    if (badge) {
                                        const newCount = remainingNotifications.length;
                                        badge.textContent = newCount > 9 ? '9+' : newCount;
                                        if (newCount === 0) {
                                            badge.remove();
                                        }
                                    }
                                }
                            }, 300);
                        } else {
                            element.dataset.processing = 'false';
                        }
                    })
                    .catch(err => {
                        console.error('Error marking notification as read:', err);
                        element.dataset.processing = 'false';
                    });
                },
                markAllAsRead() {
                    const notifications = document.querySelectorAll('[data-notification-id]');
                    const notificationIds = Array.from(notifications).map(el => el.getAttribute('data-notification-id'));
                    
                    Promise.all(
                        notificationIds.map(id => 
                            fetch(`/notifications/${id}/mark-as-read`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': this.csrfToken,
                                },
                            })
                        )
                    )
                    .then(() => {
                        window.location.reload();
                    })
                    .catch(err => console.error('Error marking all notifications as read:', err));
                }
            }"
            @click.outside="profileOpen = false; notifyOpen = false"
        >
            <p class="hidden sm:block font-semibold text-[#0b49a0]">
                {{ $user?->name ?? 'Administrator' }}
            </p>
            <button
                type="button"
                class="inline-flex items-center rounded-full bg-[#e1e5f3] text-[#0b49a0] px-4 py-1.5 font-semibold shadow-inner shadow-white hover:bg-[#d1d5e3] transition"
                @click="window.dispatchEvent(new CustomEvent('open-action-center'))"
            >
                Action Center
            </button>
            <div class="relative">
                <button class="relative rounded-full bg-white p-2 shadow border border-gray-200" type="button" @click="notifyOpen = !notifyOpen; profileOpen = false">
                    @if($unreadCount > 0)
                        <span class="notification-badge absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1 rounded-full bg-red-500 text-white text-xs font-semibold">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                    @endif
                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <div
                    x-cloak
                    x-show="notifyOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2"
                    class="absolute right-0 mt-3 w-72 max-h-96 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-xl shadow-indigo-500/10 p-4 space-y-4 overflow-hidden flex flex-col"
                >
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                        @if($unreadCount > 0)
                            <button 
                                class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline" 
                                type="button"
                                x-on:click="markAllAsRead()"
                            >
                                Mark all read
                            </button>
                        @endif
                    </div>
                    <div class="space-y-3 text-sm overflow-y-auto pr-1">
                        @if($unreadNotifications->count() > 0)
                            @foreach($unreadNotifications as $notification)
                                <div 
                                    class="rounded-xl border border-gray-100 dark:border-gray-800 p-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition cursor-pointer"
                                    x-on:click.stop="markNotificationAsRead({{ $notification->id }}, $el)"
                                    data-notification-id="{{ $notification->id }}"
                                    data-processing="false"
                                >
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $notification->notification_type }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">{{ $notification->content }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="rounded-xl border border-gray-100 dark:border-gray-800 p-4 text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">No new notifications</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="relative">
                <button
                    type="button"
                    class="relative rounded-full bg-white p-2 shadow border border-gray-200"
                    @click="profileOpen = !profileOpen"
                >
                    @if($user && $user->profile_image)
                        <img 
                            src="{{ asset('storage/' . $user->profile_image) }}" 
                            alt="{{ $user->name }}"
                            class="h-5 w-5 rounded-full object-cover"
                        >
                    @else
                        <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-gray-900 text-white dark:bg-white dark:text-gray-900">
                            @if($user && $user->name)
                                <span class="text-[10px] font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @else
                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4.5 19.125a7.5 7.5 0 0 1 15 0V21h-15v-1.875Z" />
                                </svg>
                            @endif
                        </span>
                    @endif
                </button>

                <div
                    x-cloak
                    x-show="profileOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2"
                    class="absolute right-0 mt-3 w-64 rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-xl shadow-indigo-500/10 p-4 space-y-3"
                >
                    <div class="flex items-center gap-3">
                        @if($user && $user->profile_image)
                            <img 
                                src="{{ asset('storage/' . $user->profile_image) }}" 
                                alt="{{ $user->name }}"
                                class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700"
                            >
                        @else
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-lg font-semibold">
                                {{ $user && $user->name ? strtoupper(substr($user->name, 0, 1)) : 'U' }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user?->name ?? 'Guest user' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user?->email ?? 'user@example.com' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile') }}" class="flex items-center justify-between rounded-xl border border-gray-200 dark:border-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800">
                        View profile
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5 7 7-7 7" />
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 text-white dark:bg-white dark:text-gray-900 px-4 py-2 text-sm font-semibold">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3-3m0 0 3 3m-3-3v12" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
