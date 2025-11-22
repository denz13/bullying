<?php

namespace App\Http\Controllers\welcome;

use App\Http\Controllers\Controller;
use App\Models\RequestCounseling;
use App\Models\ShareExperience;
use App\Models\notification;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
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

        $counselingRequest = RequestCounseling::create($data);

        // Create notification
        notification::create([
            'notification_type' => 'Request Counseling',
            'content' => 'You have a new notification about request counseling from ' . ($data['fullname'] ?: 'Anonymous') . '.',
            'status' => 'unread',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('counseling_submitted', true);
    }

    public function storeExperience(Request $request)
    {
        $data = $request->validate([
            'type_experience' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type_of_support' => ['nullable', 'string'],
            'is_anonymously' => ['nullable', 'boolean'],
        ]);

        $data['is_anonymously'] = (bool) ($data['is_anonymously'] ?? false);
        $data['status'] = 'pending';

        ShareExperience::create($data);

        // Create notification
        notification::create([
            'notification_type' => 'Share Experience',
            'content' => 'You have a new notification about shared experience. A student has shared their experience regarding ' . $data['type_experience'] . '.',
            'status' => 'unread',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('share_experience_submitted', true);
    }
}
