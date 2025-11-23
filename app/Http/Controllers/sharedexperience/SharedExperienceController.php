<?php

namespace App\Http\Controllers\sharedexperience;

use App\Http\Controllers\Controller;
use App\Models\ShareExperience;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class SharedExperienceController extends Controller
{
    public function index()
    {
        $experiences = ShareExperience::query()
            ->latest()
            ->paginate(10);

        // Get unique experience types from database
        $experienceTypes = ShareExperience::select('type_experience')
            ->distinct()
            ->whereNotNull('type_experience')
            ->orderBy('type_experience')
            ->pluck('type_experience')
            ->unique()
            ->values()
            ->toArray();

        // Transform data for view
        $stories = $experiences->map(function ($experience) {
            return [
                'id' => $experience->id,
                'student' => $experience->is_anonymously ? 'Anonymous' : 'Student',
                'grade' => '—',
                'type' => $experience->type_experience ?? '—',
                'summary' => \Illuminate\Support\Str::limit($experience->content ?? '', 100),
                'hope' => $experience->type_of_support ?? '—',
                'content' => $experience->content ?? '',
                'created_at' => $experience->created_at,
            ];
        });

        return view('shared-experience.shared-experience', [
            'stories' => $experiences, // Using 'stories' to match the view variable name
            'experienceTypes' => $experienceTypes,
        ]);
    }

    public function print(Request $request)
    {
        $query = ShareExperience::query();

        // Apply experience type filter
        if ($request->has('type') && $request->type !== '' && $request->type !== null) {
            $query->where('type_experience', $request->type);
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
                $q->where('type_experience', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%")
                    ->orWhere('type_of_support', 'like', "%{$searchTerm}%");
            });
        }

        $experiences = $query->orderBy('created_at', 'desc')->get();

        // Get filter information for display
        $filters = [
            'type' => $request->type ?? null,
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

        $html = view('reports.shared-experience-report', [
            'experiences' => $experiences,
            'filters' => $filters,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response()->make($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="shared-experience-report.pdf"',
        ]);
    }

    public function markAsRead($id)
    {
        try {
            $experience = ShareExperience::findOrFail($id);
            $experience->update(['status' => 'read']);
            
            return response()->json([
                'success' => true,
                'message' => 'Experience marked as read successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark experience as read.',
            ], 500);
        }
    }
}
