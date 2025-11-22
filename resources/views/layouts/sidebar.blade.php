@php
    $navItems = collect(config('navigation.primary', []))->map(function ($item) {
        $route = $item['route'] ?? null;
        $url = $route ? route($route) : ($item['url'] ?? '#');

        return array_merge($item, ['url' => $url]);
    });
    $icons = [
        'grid' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h7.5v7.5h-7.5zM12.75 3.75h7.5v7.5h-7.5zM12.75 12.75h7.5v7.5h-7.5zM3.75 12.75h7.5v7.5h-7.5z" />',
        'flag' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-6m0 0c3-2 6-2 9 0s6 2 9 0v-9c-3 2-6 2-9 0s-6-2-9 0m0 9V4" />',
        'document' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m4.5 4.5h-12A2.25 2.25 0 0 1 5.25 18.75V5.25A2.25 2.25 0 0 1 7.5 3h7.257a2.25 2.25 0 0 1 1.59.659l4.243 4.243a2.25 2.25 0 0 1 .66 1.591v9.257a2.25 2.25 0 0 1-2.25 2.25Z" />',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.964 0a9 9 0 1 0-11.964 0m11.964 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />',
        'check-circle' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
        'exclamation-triangle' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />',
        'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />',
        'settings' => '<path stroke-linecap="round" stroke-linejoin="round" d="m10.343 3.94 1.314-1.226a1.875 1.875 0 0 1 2.5 0l1.314 1.227 1.74-.174a1.875 1.875 0 0 1 2.042 1.651l.173 1.74 1.227 1.314a1.875 1.875 0 0 1 0 2.5l-1.227 1.314.173 1.74a1.875 1.875 0 0 1-1.651 2.042l-1.74.173-1.314 1.227a1.875 1.875 0 0 1-2.5 0l-1.314-1.227-1.74.173a1.875 1.875 0 0 1-2.042-1.651l-.173-1.74-1.227-1.314a1.875 1.875 0 0 1 0-2.5l1.227-1.314-.173-1.74a1.875 1.875 0 0 1 1.651-2.042l1.74-.173Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />',
    ];
@endphp

<aside class="hidden lg:flex lg:flex-col w-72 bg-gradient-to-b from-[#0f2e75] to-[#0b49a0] text-white border-r border-[#0b2d68] px-6 py-8 gap-8 shadow-[8px_0_35px_rgba(15,46,117,0.25)]">
    <div class="space-y-4">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 border border-white/20 text-lg font-semibold tracking-widest">
                GO
            </span>
            <div>
                <a href="{{ url('/') }}" class="text-xl font-semibold tracking-[0.3em] text-white">GUIDANCE</a>
                <p class="text-xs uppercase tracking-[0.4em] text-white/70">Office</p>
            </div>
        </div>
        <p class="text-xs text-white/70 leading-relaxed">
            Supporting every student with clarity, compassion, and quick response.
        </p>
    </div>

    <nav class="flex-1 space-y-1">
        @foreach ($navItems as $item)
            @php
                $active = $item['route'] ?? null
                    ? request()->routeIs($item['route'])
                    : false;
            @endphp
            <a
                href="{{ $item['url'] }}"
                class="flex items-center gap-4 rounded-2xl px-4 py-3 text-sm font-semibold transition
                       {{ $active ? 'bg-white text-[#0f2e75] shadow-[0_12px_30px_rgba(15,46,117,0.35)]' : 'text-white/70 hover:bg-white/10' }}"
            >
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/20
                             {{ $active ? 'bg-[#0f2e75]/10 text-[#0f2e75]' : 'text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                        {!! $icons[$item['icon']] !!}
                    </svg>
                </span>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="rounded-2xl bg-white/10 border border-white/20 px-4 py-3 text-xs text-white/80 space-y-1">
        <p class="font-semibold text-white tracking-[0.3em] uppercase">Need urgent help?</p>
        <p class="text-sm font-medium">Call (046) 123-4567 ext. 102</p>
        <p>Guidance lines are open 7am–7pm.</p>
    </div>
</aside>
