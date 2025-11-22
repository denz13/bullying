<?php

namespace App\Http\Controllers\schedulecalendar;

use App\Http\Controllers\Controller;
use App\Models\RequestCounseling;
use Illuminate\Http\Request;

class ScheduleCalendarController extends Controller
{
    public function index()
    {
        return view('schedule-calendar.schedule-calendar');
    }

    public function getEvents(Request $request)
    {
        // Get approved and completed counseling requests
        $requests = RequestCounseling::whereIn('status', ['approved', 'completed'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Format events for FullCalendar
        $events = $requests->map(function ($request) {
            $date = $request->created_at->format('Y-m-d');
            $statusColor = $request->status === 'approved' ? '#3b82f6' : '#10b981'; // blue for approved, green for completed
            
            return [
                'id' => $request->id,
                'title' => $request->fullname ?: 'Anonymous',
                'start' => $date,
                'backgroundColor' => $statusColor,
                'borderColor' => $statusColor,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'fullname' => $request->fullname ?: 'Anonymous',
                    'grade_section' => $request->grade_section,
                    'urgent_level' => $request->urgent_level,
                    'status' => $request->status,
                    'content' => $request->content,
                    'support_method' => $request->support_method,
                    'remarks' => $request->remarks,
                    'contact_details' => $request->contact_details,
                ],
            ];
        });

        return response()->json($events);
    }
}
