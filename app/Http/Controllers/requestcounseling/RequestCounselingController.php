<?php

namespace App\Http\Controllers\requestcounseling;

use App\Http\Controllers\Controller;
use App\Models\RequestCounseling;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Dompdf\Dompdf;
use Dompdf\Options;

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

    public function destroy($id)
    {
        $requestCounseling = RequestCounseling::findOrFail($id);
        $requestCounseling->delete();

        return response()->json([
            'success' => true,
            'message' => 'Counseling request deleted successfully.',
        ]);
    }

    public function updateRemarks(Request $request, $id)
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
            'remarks' => trim($remarks),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Remarks updated successfully.',
        ]);
    }

    public function print(Request $request)
    {
        $query = RequestCounseling::query();

        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Apply date range filter
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply search filter
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('fullname', 'like', "%{$searchTerm}%")
                    ->orWhere('grade_section', 'like', "%{$searchTerm}%")
                    ->orWhere('contact_details', 'like', "%{$searchTerm}%")
                    ->orWhere('urgent_level', 'like', "%{$searchTerm}%")
                    ->orWhere('status', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->get();

        // Get filter information for display
        $filters = [
            'status' => $request->status ?? null,
            'date_from' => $request->date_from ?? null,
            'date_to' => $request->date_to ?? null,
            'search' => $request->search ?? null,
        ];

        // Generate PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        $html = view('reports.counseling-request-report', [
            'requests' => $requests,
            'filters' => $filters,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="counseling-request-report.pdf"');
    }
}
