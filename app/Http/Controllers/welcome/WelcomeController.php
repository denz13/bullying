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
        // Get all images from public/img folder and convert to base64
        $imgPath = public_path('img');
        $images = [];
        
        // Check if directory exists
        if (is_dir($imgPath)) {
            $files = scandir($imgPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = $imgPath . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath) && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        // Read file and convert to base64
                        $imageData = file_get_contents($filePath);
                        $imageInfo = getimagesize($filePath);
                        $mimeType = $imageInfo['mime'] ?? 'image/jpeg';
                        $base64 = base64_encode($imageData);
                        $images[] = 'data:' . $mimeType . ';base64,' . $base64;
                    }
                }
            }
        }
        
        // Sort images alphabetically for consistent order
        // Note: We can't sort base64 strings, so we'll keep the file order
        
        // If no images found, use default placeholder
        if (empty($images)) {
            $images = [
                'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80',
                'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&q=80',
                'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1920&q=80',
            ];
        }
        
        return view('welcome', compact('images'));
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
