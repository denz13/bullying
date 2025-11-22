<?php

namespace App\Http\Controllers\requestcounseling;

use App\Http\Controllers\Controller;
use App\Models\RequestCounseling;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RequestCounselingController extends Controller
{
    public function index()
    {
        $requests = RequestCounseling::query()
            ->latest()
            ->paginate(10);

        // Get unique status values from database
        $statuses = RequestCounseling::select('status')
            ->distinct()
            ->whereNotNull('status')
            ->orderBy('status')
            ->pluck('status')
            ->map(function ($status) {
                return ucfirst($status);
            })
            ->unique()
            ->values()
            ->toArray();

        return view('request-counseling.request-counseling', [
            'requests' => $requests,
            'statuses' => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fullname' => ['nullable', 'string', 'max:255'],
            'grade_section' => ['nullable', 'string', 'max:255'],
            'contact_details' => ['nullable', 'string', 'max:255'],
            'urgent_level' => ['required', 'string', 'max:50'],
            'content' => ['required', 'string'],
            'support_method' => ['nullable', 'string', 'max:100'],
        ]);

        $data['status'] = 'pending';

        RequestCounseling::create($data);

        return back()->with('counseling_submitted', true);
    }

    public function approve(Request $request, $id)
    {
        $requestCounseling = RequestCounseling::findOrFail($id);
        $requestCounseling->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Counseling request approved successfully.',
        ]);
    }

    public function markAsCompleted(Request $request, $id)
    {
        // Get remarks from JSON body or regular input
        $remarks = $request->json('remarks') ?? $request->input('remarks');
        
        // Validate remarks
        if (empty($remarks) || !is_string($remarks)) {
            return response()->json([
                'success' => false,
                'message' => 'Remarks are required and must be a string.',
            ], 422);
        }

        $requestCounseling = RequestCounseling::findOrFail($id);
        $requestCounseling->update([
            'status' => 'completed',
            'remarks' => trim($remarks),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Counseling request marked as completed successfully.',
        ]);
    }

    public function reject(Request $request, $id)
    {
        // Get note from JSON body or regular input
        $note = $request->json('note') ?? $request->input('note');
        
        // Validate that note is provided
        if (empty($note) || !is_string($note) || trim($note) === '') {
            return response()->json([
                'success' => false,
                'message' => 'Reason for rejection is required.',
            ], 422);
        }
        
        $requestCounseling = RequestCounseling::findOrFail($id);
        $requestCounseling->update([
            'status' => 'rejected',
            'remarks' => trim($note),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Counseling request rejected successfully.',
        ]);
    }
}
