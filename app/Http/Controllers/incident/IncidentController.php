<?php

namespace App\Http\Controllers\incident;

use App\Http\Controllers\Controller;
use App\Models\list_incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = list_incident::query()
            ->latest()
            ->paginate(10);

        // Get unique status values from database
        $statuses = list_incident::select('status')
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

        return view('incident.incident', [
            'incidents' => $incidents,
            'statuses' => $statuses,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'student' => ['required', 'string', 'max:255'],
                'incident_type' => ['required', 'string', 'max:255'],
                'date_reported' => ['required', 'date'],
                'grade_section' => ['nullable', 'string', 'max:255'],
                'department' => ['nullable', 'string', 'max:255'],
                'status' => ['required', 'string', 'max:50'],
                'priority' => ['required', 'string', 'max:50'],
                'remarks' => ['nullable', 'string'],
                'student_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            ]);

            // Handle file upload - convert to base64
            if ($request->hasFile('student_image')) {
                $file = $request->file('student_image');
                $imageData = file_get_contents($file->getRealPath());
                $base64 = base64_encode($imageData);
                $mimeType = $file->getMimeType();
                $data['student_image'] = 'data:' . $mimeType . ';base64,' . $base64;
            }

            // Remove remarks if it's empty or null to avoid database issues
            if (empty($data['remarks'])) {
                unset($data['remarks']);
            }

            list_incident::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Incident added successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add incident: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'student' => ['required', 'string', 'max:255'],
                'incident_type' => ['required', 'string', 'max:255'],
                'date_reported' => ['required', 'date'],
                'grade_section' => ['nullable', 'string', 'max:255'],
                'department' => ['nullable', 'string', 'max:255'],
                'status' => ['required', 'string', 'max:50'],
                'priority' => ['required', 'string', 'max:50'],
                'remarks' => ['nullable', 'string'],
                'student_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:5120'],
            ]);

            $incident = list_incident::findOrFail($id);

            // Handle file upload - convert to base64
            if ($request->hasFile('student_image')) {
                $file = $request->file('student_image');
                $imageData = file_get_contents($file->getRealPath());
                $base64 = base64_encode($imageData);
                $mimeType = $file->getMimeType();
                $data['student_image'] = 'data:' . $mimeType . ';base64,' . $base64;
            }

            // Remove remarks if it's empty or null to avoid database issues
            if (empty($data['remarks'])) {
                $data['remarks'] = null;
            }

            $incident->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Incident updated successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update incident: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $incident = list_incident::findOrFail($id);
        $incident->delete();

        return response()->json([
            'success' => true,
            'message' => 'Incident deleted successfully.',
        ]);
    }

    public function print(Request $request)
    {
        $query = list_incident::query();

        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Apply date range filter
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('date_reported', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('date_reported', '<=', $request->date_to);
        }

        // Apply search filter
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('student', 'like', "%{$searchTerm}%")
                    ->orWhere('grade_section', 'like', "%{$searchTerm}%")
                    ->orWhere('department', 'like', "%{$searchTerm}%")
                    ->orWhere('incident_type', 'like', "%{$searchTerm}%")
                    ->orWhere('status', 'like', "%{$searchTerm}%")
                    ->orWhere('priority', 'like', "%{$searchTerm}%");
            });
        }

        $incidents = $query->orderBy('date_reported', 'desc')->get();

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

        $html = view('reports.incident-report', [
            'incidents' => $incidents,
            'filters' => $filters,
            'currentUser' => Auth::user(),
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Use explicit response headers for better compatibility with hosting environments
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="incident-report.pdf"');
    }

    public function printSingle($id)
    {
        $incident = list_incident::findOrFail($id);
        
        // Generate PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        $html = view('reports.incident-report', [
            'incidents' => collect([$incident]),
            'filters' => [],
            'currentUser' => Auth::user(),
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'incident-report-' . str_replace(' ', '-', strtolower($incident->student)) . '-' . $incident->id . '.pdf';
        
        // Use explicit response headers for better compatibility with hosting environments
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }
}
