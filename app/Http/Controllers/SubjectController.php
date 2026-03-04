<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Subject::query()->with(['schoolClass', 'teacher']);
        
        if ($user && $user->role === 'teacher') {
            $query->where('teacher_id', $user->id);
        } elseif ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }
        
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'school_class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $subject = Subject::create($validated);

        return response()->json([
            'success' => true,
            'subject' => $subject->load(['schoolClass', 'teacher']),
            'message' => 'Subject assigned successfully.'
        ]);
    }

    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json(['success' => true]);
    }
}
