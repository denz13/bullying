@extends('layouts.master')

@section('content')
    @php
        $monthlyStats = collect($monthlyStats ?? []);
        if ($monthlyStats->isEmpty()) {
            $monthlyStats = collect([
                ['month' => 'Jan', 'support' => 8, 'shared' => 6, 'resolved' => 10],
                ['month' => 'Feb', 'support' => 15, 'shared' => 9, 'resolved' => 12],
                ['month' => 'Mar', 'support' => 19, 'shared' => 13, 'resolved' => 17],
                ['month' => 'Apr', 'support' => 23, 'shared' => 18, 'resolved' => 21],
                ['month' => 'May', 'support' => 27, 'shared' => 22, 'resolved' => 25],
                ['month' => 'Jun', 'support' => 31, 'shared' => 26, 'resolved' => 29],
            ]);
        }
        $supportRequests = $supportRequests ?? $monthlyStats->sum('support');
        $sharedExperiences = $sharedExperiences ?? $monthlyStats->sum('shared');
        $resolvedCases = $resolvedCases ?? $monthlyStats->sum('resolved');
    @endphp

    <section class="w-full px-6 lg:px-10 py-10 space-y-8">
        <div class="rounded-3xl bg-gradient-to-r from-[#0f2e75] via-[#0b49a0] to-[#0b2d68] text-white p-10 relative overflow-hidden shadow-[0_30px_80px_rgba(15,46,117,0.45)]">
            <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1600&q=80')] bg-cover bg-center mix-blend-luminosity"></div>
            <div class="relative">
                <p class="text-sm uppercase tracking-[0.4em] text-white/70">Welcome back</p>
                <h1 class="mt-2 text-3xl font-semibold">
                    Hello, {{ \Illuminate\Support\Str::upper(auth()->user()->name ?? 'Administrator') }}!
                </h1>
                <p class="mt-4 text-base text-white/90">
                    “Be a yardstick of quality. Some people aren’t used to an environment where excellence is expected.”
                    <span class="font-semibold">— Steve Jobs</span>
                </p>
            </div>
        </div>

      

        @php
            $metricCards = [
                [
                    'title' => 'Request Counseling Support',
                    'value' => number_format($supportRequests),
                    'trend' => 'Total submissions received',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m3 3a3 3 0 1 0-6 0m13.5 0a8.988 8.988 0 0 1-4.5 7.794m-9 0A8.988 8.988 0 0 1 2.25 15V6a2.25 2.25 0 0 1 2.25-2.25h15A2.25 2.25 0 0 1 21.75 6v9Z" />',
                    'accent' => 'from-[#4c8dff] to-[#1f57ff]',
                    'progress' => 70,
                ],
                [
                    'title' => 'Resolved cases',
                    'value' => number_format($resolvedCases),
                    'trend' => 'Total resolved across campuses',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12 5 5L20 6" />',
                    'accent' => 'from-[#34d399] to-[#059669]',
                    'progress' => 75,
                ],
                [
                    'title' => 'Shared Experiences',
                    'value' => number_format($sharedExperiences),
                    'trend' => 'Total stories submitted',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h5m-9 6h12a4 4 0 0 0 4-4V8a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4Z" />',
                    'accent' => 'from-[#fcd34d] to-[#f59e0b]',
                    'progress' => 60,
                ],
            ];
        @endphp

        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($metricCards as $card)
                <div class="rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 pb-8 shadow-[0_20px_45px_rgba(15,23,42,0.08)] overflow-hidden relative">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $card['title'] }}</p>
                            <p class="mt-3 text-4xl font-semibold text-gray-900 dark:text-white" data-dashboard-card-value>{{ $card['value'] }}</p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br {{ $card['accent'] }} text-white shadow-lg shadow-indigo-500/20 flex-shrink-0 ml-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $card['icon'] !!}
                            </svg>
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">{{ $card['trend'] }}</p>
                    <div class="absolute inset-x-6 bottom-6 h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r {{ $card['accent'] }}" style="width: {{ $card['progress'] ?? 70 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Monthly trend</h3>
                </div>
            </div>
            <div
                class="h-72 flex items-center justify-center text-sm text-gray-500 dark:text-gray-400"
                id="dashboardChart"
                data-labels='@json($monthlyStats->pluck('month'))'
                data-support='@json($monthlyStats->pluck('support'))'
                data-shared='@json($monthlyStats->pluck('shared'))'
                data-resolved='@json($monthlyStats->pluck('resolved'))'
            >
                <canvas id="incidentTimelineCanvas" class="w-full h-full"></canvas>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script src="{{ asset('js/dashboard/dashboard.js') }}" defer></script>
@endpush
