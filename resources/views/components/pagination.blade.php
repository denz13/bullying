@props(['paginator'])

@if ($paginator instanceof \Illuminate\Contracts\Pagination\Paginator)
    @php
        /** @var \Illuminate\Contracts\Pagination\Paginator $paginator */
        $isLengthAware = $paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
        $onFirstPage = method_exists($paginator, 'onFirstPage') ? $paginator->onFirstPage() : true;
        $hasMorePages = method_exists($paginator, 'hasMorePages') ? $paginator->hasMorePages() : false;
    @endphp
    <nav class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between text-sm text-gray-600 dark:text-gray-300" aria-label="Pagination">
        <div>
            @if ($isLengthAware && method_exists($paginator, 'firstItem') && $paginator->firstItem())
                <span>Showing</span>
                <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                <span>to</span>
                <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                <span>of</span>
                <span class="font-semibold">{{ method_exists($paginator, 'total') ? $paginator->total() : 0 }}</span>
                <span>results</span>
            @elseif ($isLengthAware && method_exists($paginator, 'total'))
                <span>Showing</span>
                <span class="font-semibold">0</span>
                <span>of</span>
                <span class="font-semibold">{{ $paginator->total() }}</span>
                <span>results</span>
            @else
                <span>Page {{ $paginator->currentPage() }}</span>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <a
                href="{{ $paginator->previousPageUrl() ?: '#' }}"
                @class([
                    'inline-flex items-center gap-2 rounded-full border px-4 py-2 transition text-sm font-semibold',
                    'text-gray-400 border-gray-200 dark:border-gray-800 cursor-not-allowed' => $onFirstPage,
                    'text-gray-800 dark:text-gray-100 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' => ! $onFirstPage,
                ])
                aria-disabled="{{ $onFirstPage ? 'true' : 'false' }}"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15 19-7-7 7-7" />
                </svg>
                Previous
            </a>

            <a
                href="{{ $paginator->nextPageUrl() ?: '#' }}"
                @class([
                    'inline-flex items-center gap-2 rounded-full border px-4 py-2 transition text-sm font-semibold',
                    'text-gray-400 border-gray-200 dark:border-gray-800 cursor-not-allowed' => ! $hasMorePages,
                    'text-gray-800 dark:text-gray-100 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' => $hasMorePages,
                ])
                aria-disabled="{{ $hasMorePages ? 'false' : 'true' }}"
            >
                Next
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5 7 7-7 7" />
                </svg>
            </a>
        </div>
    </nav>
@endif
