<?php

namespace App\Http\Controllers\resolvecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestCounseling;
use Dompdf\Dompdf;
use Dompdf\Options;

class ResolveCasesController extends Controller
{
    public function index()
    {
        $requests = RequestCounseling::query()
            ->latest()
            ->where('status', 'completed')
            ->paginate(10);

        return view('resolve-cases.resolve-cases', [
            'requests' => $requests,
        ]);
    }

    public function print(Request $request)
    {
        $query = RequestCounseling::query()
            ->where('status', 'completed');

        // Apply date range filter
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('updated_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('updated_at', '<=', $request->date_to);
        }

        // Apply search filter
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('fullname', 'like', "%{$searchTerm}%")
                    ->orWhere('grade_section', 'like', "%{$searchTerm}%")
                    ->orWhere('contact_details', 'like', "%{$searchTerm}%")
                    ->orWhere('urgent_level', 'like', "%{$searchTerm}%")
                    ->orWhere('remarks', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        $requests = $query->orderBy('updated_at', 'desc')->get();

        // Get filter information for display
        $filters = [
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

        $html = view('reports.resolve-cases-report', [
            'requests' => $requests,
            'filters' => $filters,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="resolve-cases-report.pdf"');
    }
}
