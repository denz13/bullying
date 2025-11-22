<?php

namespace App\Http\Controllers\resolvecases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestCounseling;

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
}
