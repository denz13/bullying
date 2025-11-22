@props([
    'id' => null,
    'type' => 'info',
    'title' => null,
    'message' => null,
    'subcopy' => null,
    'show' => false,
])

@php
    $colors = [
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-200 dark:border-emerald-500/30',
        'info' => 'bg-blue-50 text-blue-800 border-blue-100 dark:bg-blue-500/10 dark:text-blue-200 dark:border-blue-500/30',
        'warning' => 'bg-amber-50 text-amber-800 border-amber-100 dark:bg-amber-500/10 dark:text-amber-200 dark:border-amber-500/30',
        'danger' => 'bg-rose-50 text-rose-800 border-rose-100 dark:bg-rose-500/10 dark:text-rose-200 dark:border-rose-500/30',
    ];
    $colorClasses = $colors[$type] ?? $colors['info'];
@endphp

<div
    id="{{ $id }}"
    x-data="{ visible: @js((bool) $show) }"
    x-effect="visible ? $el.classList.remove('hidden') : $el.classList.add('hidden')"
    x-show="visible"
    x-transition
    class="notification-toast {{ $show ? '' : 'hidden' }} {{ $colorClasses }} rounded-2xl border px-5 py-4 text-sm shadow-lg shadow-black/5"
>
    <div class="flex justify-between gap-4">
        <div class="space-y-1">
            @if ($title)
                <p class="text-base font-semibold">{{ $title }}</p>
            @endif
            @if ($message)
                <p>{{ $message }}</p>
            @endif
            @if ($subcopy)
                <p class="text-xs opacity-75">{{ $subcopy }}</p>
            @endif
        </div>
        <button
            type="button"
            class="inline-flex h-8 w-8 items-center justify-center rounded-full text-current/70 hover:text-current"
            x-on:click="visible = false"
        >
            <span class="sr-only">Close</span>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

