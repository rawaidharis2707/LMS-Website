<?php

namespace App\Http\Controllers;

use App\Models\SchoolContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolContentController extends Controller
{
    /**
     * Get content (notes, assignments, etc.) based on filters.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = SchoolContent::query()->with(['subject', 'schoolClass', 'author']);

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($user->role === 'student') {
            $query->where('school_class_id', $user->school_class_id);
        } elseif ($user->role === 'teacher') {
            $query->where('author_id', $user->id);
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    /**
     * Store new content (upload notes/assignments).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:assignment,note,lecture',
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|max:10240', // 10MB limit
            'video_url' => 'nullable|url',
        ]);

        $contentData = $request->only(['title', 'description', 'type', 'school_class_id', 'subject_id', 'due_date', 'video_url']);
        $contentData['author_id'] = $request->user()->id;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('content', 'public');
            $contentData['file_path'] = $path;
        }

        $content = SchoolContent::create($contentData);

        return response()->json(['success' => true, 'content' => $content, 'message' => 'Content uploaded successfully.']);
    }

    /**
     * Remove the specified content.
     */
    public function destroy(Request $request, string $id)
    {
        $content = SchoolContent::findOrFail($id);
        
        // Ensure only author or admin can delete
        if ($request->user()->role !== 'admin' && $content->author_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $content->delete();
        return response()->json(['success' => true, 'message' => 'Content deleted.']);
    }
}
