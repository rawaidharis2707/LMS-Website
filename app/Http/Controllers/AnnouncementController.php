<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Get all announcements for the current user.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Announcement::query()->orderByDesc('created_at');

        if ($user->role === 'student') {
            $query->whereIn('target', ['all', 'students'])
                  ->orWhere(function ($q) use ($user) {
                      $q->where('target', 'class')->where('target_value', $user->enrolled_class);
                  });
        } elseif ($user->role === 'teacher') {
            $query->whereIn('target', ['all', 'teachers']);
        }
        // Admin and Superadmin see all by default

        return response()->json($query->get());
    }

    /**
     * Store a new announcement.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|string',
            'target_value' => 'nullable|string',
            'priority' => 'required|string',
        ]);

        $validated['author'] = $request->user()->name;

        $announcement = Announcement::create($validated);

        return response()->json([
            'success' => true,
            'announcement' => $announcement,
            'message' => 'Announcement created successfully.',
        ], 201);
    }

    /**
     * Delete an announcement.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return response()->json(['success' => true]);
    }
}
