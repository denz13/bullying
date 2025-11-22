@extends('layouts.master')

@section('content')
    <section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10">
        <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6 shadow-[0_20px_45px_rgba(15,23,42,0.08)]">
            <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">Shared experiences</h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Stories submitted by students to inspire courage and empathy.</p>
                </div>
                <div class="relative w-full lg:w-auto lg:max-w-sm">
                    <input
                        type="search"
                        id="sharedExperienceSearch"
                        placeholder="Search stories..."
                        class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    <svg class="absolute right-3 sm:right-4 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-4.35-4.35M16.5 10.5a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                    </svg>
                </div>
            </div>

            <div class="border border-gray-100 dark:border-gray-800 rounded-xl sm:rounded-2xl overflow-hidden">
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800 text-sm" id="sharedExperienceTable">
                    <thead class="bg-gray-50 dark:bg-gray-900/60 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[140px]">Student</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[150px] hidden md:table-cell">Experience type</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[200px]">Summary</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[200px] hidden lg:table-cell">Quote of hope</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-200">
                    @forelse ($stories as $story)
                            <tr
                                class="hover:bg-gray-50/70 dark:hover:bg-gray-800/60 transition"
                                data-experience-row
                                data-search="{{ strtolower($story['student'] . ' ' . $story['grade'] . ' ' . $story['type'] . ' ' . $story['summary']) }}"
                            >
                                <td class="px-3 sm:px-4 py-3 sm:py-4">
                                    <p class="font-semibold text-sm sm:text-base text-gray-900 dark:text-white break-words">{{ $story['student'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $story['grade'] }}</p>
                                    <div class="mt-2 md:hidden space-y-1">
                                        <div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Type: </span>
                                            <span class="inline-flex items-center gap-1 rounded-full border border-indigo-100 dark:border-indigo-900 px-2 py-0.5 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                                {{ $story['type'] }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Hope: </span>
                                            <span class="text-xs italic text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::words($story['hope'] ?? '', 10) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4 hidden md:table-cell">
                                    <span class="inline-flex items-center gap-1 sm:gap-2 rounded-full border border-indigo-100 dark:border-indigo-900 px-2 sm:px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-300 break-words">
                                        <i class="fa-solid fa-comments hidden sm:inline"></i>
                                        <span class="line-clamp-2">{{ $story['type'] }}</span>
                                    </span>
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm leading-relaxed text-gray-600 dark:text-gray-300 break-words">
                                    {{ \Illuminate\Support\Str::words($story['summary'] ?? '', 20) }}
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm italic text-gray-500 dark:text-gray-400 hidden lg:table-cell break-words">
                                    {{ $story['hope'] }}
                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No shared stories yet.
                            </td>
                        </tr>
                    @endforelse
                    @if ($stories instanceof \Illuminate\Contracts\Pagination\Paginator && method_exists($stories, 'total') && $stories->total() > 0)
                        <tr id="sharedExperienceEmpty" class="hidden">
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No stories match your search.
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                    </div>
                </div>
            </div>
            @if ($stories instanceof \Illuminate\Contracts\Pagination\Paginator)
                <x-pagination :paginator="$stories" />
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/shared-experience/shared-experience.js') }}" defer></script>
@endpush
