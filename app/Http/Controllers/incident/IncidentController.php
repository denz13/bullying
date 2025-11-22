<?php

namespace App\Http\Controllers\incident;

use App\Http\Controllers\Controller;
use App\Models\list_incident;
use Illuminate\Http\Request;
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
        $data = $request->validate([
            'student' => ['required', 'string', 'max:255'],
            'incident_type' => ['required', 'string', 'max:255'],
            'date_reported' => ['required', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'priority' => ['required', 'string', 'max:50'],
        ]);

        list_incident::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Incident added successfully.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'student' => ['required', 'string', 'max:255'],
            'incident_type' => ['required', 'string', 'max:255'],
            'date_reported' => ['required', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'priority' => ['required', 'string', 'max:50'],
        ]);

        $incident = list_incident::findOrFail($id);
        $incident->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Incident updated successfully.',
        ]);
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
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('incident-report.pdf', ['Attachment' => false]);
    }
}
