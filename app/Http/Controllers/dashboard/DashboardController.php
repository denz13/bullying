<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\RequestCounseling;
use App\Models\ShareExperience;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get real counts from database
        $supportRequests = RequestCounseling::count();
        $sharedExperiences = ShareExperience::count();
        $resolvedCases = RequestCounseling::where('status', 'completed')->count();

        // Get monthly stats from database
        $monthlyStats = collect();
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths(5 - $i);
            $monthName = $months[$date->month - 1];
            
            $support = RequestCounseling::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $shared = ShareExperience::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $resolved = RequestCounseling::where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $monthlyStats->push([
                'month' => $monthName,
                'support' => $support,
                'shared' => $shared,
                'resolved' => $resolved,
            ]);
        }

        // If no data, use dummy data for display
        if ($monthlyStats->sum('support') === 0 && $monthlyStats->sum('shared') === 0) {
            $monthlyStats = collect([
                ['month' => 'Jan', 'support' => 8, 'shared' => 6, 'resolved' => 10],
                ['month' => 'Feb', 'support' => 15, 'shared' => 9, 'resolved' => 12],
                ['month' => 'Mar', 'support' => 19, 'shared' => 13, 'resolved' => 17],
                ['month' => 'Apr', 'support' => 23, 'shared' => 18, 'resolved' => 21],
                ['month' => 'May', 'support' => 27, 'shared' => 22, 'resolved' => 25],
                ['month' => 'Jun', 'support' => 31, 'shared' => 26, 'resolved' => 29],
            ]);
        }

        return view('dashboard.dashboard', [
            'supportRequests' => $supportRequests,
            'sharedExperiences' => $sharedExperiences,
            'resolvedCases' => $resolvedCases,
            'monthlyStats' => $monthlyStats,
        ]);
    }
}
