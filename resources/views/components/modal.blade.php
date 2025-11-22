@props([
    'id',
    'title' => null,
    'size' => 'md',
    'show' => false,
    'zIndex' => 'z-50',
])

@php
    $sizes = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-3xl',
        'xl' => 'max-w-5xl',
    ];
    $width = $sizes[$size] ?? $sizes['md'];
@endphp

<div
    x-data="{ open: @js($show) }"
    x-on:open-modal.window="if ($event.detail === '{{ $id }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $id }}') open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 {{ $zIndex }} flex items-center justify-center px-4 py-6"
    aria-modal="true"
    role="dialog"
    aria-labelledby="{{ $id }}-title"
>
    <div
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"
        x-transition.opacity
        x-show="open"
        x-on:click="open = false"
    ></div>

    <div
        class="relative w-full {{ $width }} rounded-3xl bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-[0_30px_80px_rgba(15,23,42,0.15)]"
        x-transition.scale.origin.center
        x-show="open"
    >
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 id="{{ $id }}-title" class="text-lg font-semibold">
                {{ $title }}
            </h3>
            <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
                x-on:click="open = false"
            >
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="px-6 py-6">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-900/50 rounded-b-3xl">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
