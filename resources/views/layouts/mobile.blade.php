@php
    $mobileNavItems = collect(config('navigation.primary', []))->map(function ($item) {
        $route = $item['route'] ?? null;
        $url = $route ? route($route) : ($item['url'] ?? '#');

        return array_merge($item, ['url' => $url]);
    });
@endphp

<div
    class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm lg:hidden"
    x-show="mobileNav"
    x-transition.opacity
    x-cloak
    @click.self="mobileNav = false"
>
    <div class="absolute inset-y-0 left-0 w-80 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 px-6 py-8 overflow-y-auto"
        x-transition:enter="transition transform origin-left ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-10"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition transform origin-left ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-10"
    >
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-500">SafeSpace</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Control center</p>
            </div>
            <button class="rounded-full border border-gray-200 dark:border-gray-700 p-2" @click="mobileNav = false">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="space-y-2">
            @foreach ($mobileNavItems as $item)
                <a
                    href="{{ $item['url'] }}"
                    class="flex items-center justify-between rounded-2xl border border-gray-200 dark:border-gray-800 px-4 py-3 text-sm font-semibold text-gray-800 dark:text-gray-100"
                    @click="mobileNav = false"
                >
                    {{ $item['label'] }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5 7 7-7 7" />
                    </svg>
                </a>
            @endforeach
        </nav>

        <div class="mt-8 space-y-3 text-sm text-gray-500 dark:text-gray-400">
            <p>Help center · Privacy · Terms</p>
            <p class="text-xs">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</div>
