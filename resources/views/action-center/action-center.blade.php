@php
    use App\Models\RequestCounseling;
    $pendingRequests = RequestCounseling::where('status', 'pending')
        ->latest()
        ->limit(5)
        ->get();
    $pendingCount = RequestCounseling::where('status', 'pending')->count();
@endphp

<!-- Action Center Modal - Right Side Slide-in -->
<div
    x-data="{ actionCenterOpen: false }"
    x-init="
        $watch('actionCenterOpen', value => {
            if (value) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
        window.addEventListener('open-action-center', () => { actionCenterOpen = true; });
    "
    x-show="actionCenterOpen"
    x-cloak
    class="fixed inset-0 z-[9999] overflow-hidden pointer-events-none"
    style="display: none;"
>
    <!-- Backdrop -->
    <div
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity pointer-events-auto"
        x-show="actionCenterOpen"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="actionCenterOpen = false"
    ></div>

    <!-- Slide-in Panel -->
    <div
        class="fixed right-0 top-0 h-full w-full max-w-md bg-white dark:bg-gray-900 shadow-2xl flex flex-col pointer-events-auto"
        x-show="actionCenterOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        @click.stop
    >
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gradient-to-b from-[#2596be] to-[#2596be] text-white">
            <div>
                <h2 class="text-lg font-semibold">Action Center</h2>
                <p class="text-xs text-white/70">Quick actions and pending items</p>
            </div>
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white hover:bg-white/20 transition"
                @click="actionCenterOpen = false"
            >
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
            <!-- Pending Actions -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Pending Counseling Requests</h3>
                    @if($pendingCount > 0)
                        <a href="{{ route('request-counseling') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">View All</a>
                    @endif
                </div>
                @if($pendingCount > 0)
                    <div class="space-y-2">
                        @foreach($pendingRequests as $request)
                            <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-800/50 p-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-data="actionCenterActions()">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $request->fullname ?: 'Anonymous' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit($request->content, 60) }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-2">
                                            @if($request->grade_section)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $request->grade_section }}</span>
                                            @endif
                                            @if($request->urgent_level)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                    @if($request->urgent_level === 'urgent') bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-300
                                                    @elseif($request->urgent_level === 'high') bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300
                                                    @else bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300
                                                    @endif">
                                                    {{ ucfirst($request->urgent_level) }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                            {{ $request->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <button
                                            type="button"
                                            class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-300 transition"
                                            title="Approve"
                                            x-on:click.prevent="approveRequest(@js($request))">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m5 13 4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 dark:bg-amber-500/10 dark:text-amber-300 transition"
                                            title="Reject"
                                            x-on:click.prevent="rejectRequest(@js($request))">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($pendingCount > 5)
                            <a href="{{ route('request-counseling') }}" class="block rounded-xl border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/30 p-3 text-center hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                <p class="text-xs font-medium text-gray-600 dark:text-gray-400">
                                    +{{ $pendingCount - 5 }} more pending requests
                                </p>
                            </a>
                        @endif
                    </div>
                @else
                    <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30 p-4 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No pending counseling requests</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Approve Request Modal (Action Center) -->
<x-modal id="action-center-approve-request-modal" title="Approve Counseling Request" size="sm" zIndex="z-[10000]">
    <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300" x-data="{ requestData: null }" x-init="
        requestData = window.approveRequestData;
        window.addEventListener('open-modal', (e) => {
            if (e.detail === 'action-center-approve-request-modal') {
                requestData = window.approveRequestData;
            }
        });
    ">
        <p>
            Confirm approval for
            <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="requestData?.fullname || 'the student'"></span>.
        </p>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'action-center-approve-request-modal' }))"
            >
                Cancel
            </button>
            <button
                type="button"
                id="confirmApproveBtn"
                class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-emerald-500 transition"
            >
                Approve
            </button>
        </div>
    </div>
</x-modal>

<!-- Reject Request Modal (Action Center) -->
<x-modal id="action-center-reject-request-modal" title="Reject Counseling Request" size="lg" zIndex="z-[10000]">
    <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300" x-data="{ requestData: null }" x-init="
        requestData = window.rejectRequestData;
        window.addEventListener('open-modal', (e) => {
            if (e.detail === 'action-center-reject-request-modal') {
                requestData = window.rejectRequestData;
                const reasonInput = document.getElementById('actionCenterRejectReason');
                if (reasonInput) {
                    reasonInput.value = '';
                }
            }
        });
    ">
        <p>
            Are you sure you want to reject the request from
            <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="requestData?.fullname || 'the student'"></span>?
        </p>
        <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
            Reason for rejection <span class="text-red-500">*</span>
            <textarea
                id="actionCenterRejectReason"
                class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-amber-500 focus:ring-amber-500"
                rows="4"
                placeholder="Please provide a reason why this request is being rejected..."
                required
            ></textarea>
        </label>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'action-center-reject-request-modal' }))"
            >
                Cancel
            </button>
            <button
                type="button"
                id="confirmRejectBtn"
                class="inline-flex items-center justify-center rounded-full bg-amber-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-amber-500 transition"
            >
                Reject Request
            </button>
        </div>
    </div>
</x-modal>

<script>
    // Global variables to store request data
    window.approveRequestData = null;
    window.rejectRequestData = null;
</script>

