@extends('layouts.master')

@section('content')
    <section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10 space-y-6 md:space-y-8" x-data="resolveCasesModalActions()">
        <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6">
            <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-base sm:text-lg font-semibold">Resolved cases</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">View completed counseling requests and their resolution details</p>
                </div>
                <div class="relative w-full lg:w-auto lg:max-w-xs">
                    <input
                        type="search"
                        id="resolveCasesSearch"
                        placeholder="Search resolved cases..."
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
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800 text-sm" id="resolveCasesTable">
                            <thead class="bg-gray-50 dark:bg-gray-900/60 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left w-12 sm:w-16">No.</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[140px]">Student</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[150px] hidden md:table-cell">Preferred Support</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[120px] hidden lg:table-cell">Urgency</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[140px] hidden xl:table-cell">Completed Date</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[200px]">Remarks</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-right min-w-[100px]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-200">
                                @forelse ($requests as $request)
                                    <tr
                                        class="hover:bg-gray-50/70 dark:hover:bg-gray-800/60 transition"
                                        data-resolve-row
                                        data-search="{{ strtolower(($request->fullname ?? 'anonymous') . ' ' . ($request->grade_section ?? '') . ' ' . ($request->urgent_level ?? '') . ' ' . ($request->remarks ?? '')) }}"
                                    >
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                            {{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4">
                                            <p class="font-semibold text-sm sm:text-base break-words">{{ $request->fullname ?? 'Anonymous Student' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $request->grade_section ?? '—' }}</p>
                                            @if ($request->contact_details)
                                                <p class="text-xs text-gray-400 mt-1 break-all">{{ $request->contact_details }}</p>
                                            @endif
                                            <div class="mt-2 md:hidden space-y-1">
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Support: </span>
                                                    <span class="inline-flex items-center gap-1 rounded-full border border-indigo-100 dark:border-indigo-900 px-2 py-0.5 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                                        {{ $request->support_method ? ucfirst($request->support_method) : 'No preference' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Date: </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($request->updated_at)->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 hidden md:table-cell">
                                            <span class="inline-flex items-center gap-1 sm:gap-2 rounded-full border border-indigo-100 dark:border-indigo-900 px-2 sm:px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-300 break-words">
                                                <i class="fa-solid fa-hands-praying hidden sm:inline"></i>
                                                <span class="line-clamp-2">{{ $request->support_method ? ucfirst($request->support_method) : 'No preference' }}</span>
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden lg:table-cell break-words">
                                            {{ $request->urgent_level }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden xl:table-cell whitespace-nowrap">
                                            {{ optional($request->updated_at)->format('M d, Y • h:i A') }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm leading-relaxed text-gray-600 dark:text-gray-300 break-words">
                                            {{ \Illuminate\Support\Str::words($request->remarks ?? 'No remarks provided', 15) }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4">
                                            <div class="flex items-center justify-end gap-1 sm:gap-2">
                                                <button
                                                    type="button"
                                                    class="inline-flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-300 transition"
                                                    title="View details"
                                                    x-on:click.prevent="openModal('view', @js($request))"
                                                >
                                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="resolveCasesEmptyState">
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            No resolved cases yet.
                                        </td>
                                    </tr>
                                @endforelse
                                @if ($requests->count() > 0)
                                    <tr id="resolveCasesEmptyState" class="hidden">
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            No matches for that search.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <x-pagination :paginator="$requests" />
        </div>

        <x-modal id="view-resolve-modal" title="Resolved case details" size="lg">
            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Student</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white" x-text="$store.resolveModal.current?.fullname ?? 'Anonymous Student'"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400" x-text="$store.resolveModal.current?.grade_section ?? '—'"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Urgency level</p>
                        <p class="text-base text-indigo-600 dark:text-indigo-300" x-text="$store.resolveModal.current?.urgent_level ?? '—'"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Preferred support</p>
                    <p class="text-base text-gray-900 dark:text-white" x-text="$store.resolveModal.current?.support_method ?? 'No preference'"></p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Details</p>
                    <p class="mt-2 whitespace-pre-line break-words text-sm leading-relaxed text-gray-700 dark:text-gray-200 max-h-60 overflow-y-auto text-justify">
                        <span x-text="$store.resolveModal.current?.content ?? 'N/A'"></span>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Remarks</p>
                    <div class="mt-2 rounded-2xl bg-gray-50 dark:bg-gray-800/60 p-4 text-sm text-gray-700 dark:text-gray-200">
                        <p class="whitespace-pre-line break-words" x-text="$store.resolveModal.current?.remarks ?? 'No remarks provided'"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Completed date</p>
                    <p class="text-base text-gray-900 dark:text-white" x-text="$store.resolveModal.current?.updated_at ? new Date($store.resolveModal.current.updated_at).toLocaleString() : '—'"></p>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="inline-flex items-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('view')">
                        Close
                    </button>
                </div>
            </div>
        </x-modal>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/resolve-cases/resolve-cases.js') }}" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('resolveModal', { current: null });
            Alpine.data('resolveCasesModalActions', () => ({
                openModal(type, request) {
                    Alpine.store('resolveModal').current = request;
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: `${type}-resolve-modal` }));
                },
                closeModal(type) {
                    window.dispatchEvent(new CustomEvent('close-modal', { detail: `${type}-resolve-modal` }));
                },
            }));
        });
    </script>
@endpush
