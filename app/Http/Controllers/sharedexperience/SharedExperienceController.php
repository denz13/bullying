<?php

namespace App\Http\Controllers\sharedexperience;

use App\Http\Controllers\Controller;

class SharedExperienceController extends Controller
{
    public function index()
    {
        $stories = collect([
            [
                'student' => 'Ana Beatriz Santos',
                'grade' => 'Grade 9 - St. Jude',
                'type' => 'Verbal bullying',
                'summary' => 'Classmates were spreading rumors about Ana online. After reporting, the guidance team facilitated a mediation.',
                'hope' => '“I realized speaking up helps others do the same.”',
            ],
            [
                'student' => 'Joshua Manalo',
                'grade' => 'Grade 10 - St. Lorenzo',
                'type' => 'Cyberbullying',
                'summary' => 'Joshua experienced hurtful group chats. Counselors worked with parents to restore digital boundaries.',
                'hope' => '“Community support reminded me I am not alone.”',
            ],
            // ... additional stories can be appended here ...
        ]);

        $perPage = 2;
        $totalItems = $stories->count();
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $paginatedStories = new \Illuminate\Pagination\LengthAwarePaginator(
            $stories->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $totalItems + 1,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('shared-experience.shared-experience', [
            'stories' => $paginatedStories,
        ]);
    }
}
