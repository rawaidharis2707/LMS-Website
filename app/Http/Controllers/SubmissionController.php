<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Get submissions.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Submission::query()->with(['assignment', 'user']);

        if ($user->role === 'student') {
            $query->where('user_id', $user->id);
        } elseif ($request->has('assignment_id')) {
            $query->where('school_content_id', $request->assignment_id);
        }

        return response()->json($query->get());
    }

    /**
     * Store a new submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:school_contents,id',
            'file' => 'required|file|max:10240',
            'comments' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('submissions', 'public');

        $submission = Submission::create([
            'school_content_id' => $request->assignment_id,
            'user_id' => $request->user()->id,
            'file_path' => $path,
            'student_comments' => $request->comments,
            'status' => 'submitted',
        ]);

        return response()->json([
            'success' => true,
            'submission' => $submission,
            'message' => 'Assignment submitted successfully.'
        ]);
    }

    /**
     * Grade a submission.
     */
    public function grade(Request $request, string $id)
    {
        $submission = Submission::findOrFail($id);

        $validated = $request->validate([
            'marks_obtained' => 'required|integer',
            'teacher_feedback' => 'nullable|string',
        ]);

        $submission->update([
            'marks_obtained' => $validated['marks_obtained'],
            'teacher_feedback' => $validated['teacher_feedback'],
            'status' => 'graded',
        ]);

        return response()->json([
            'success' => true,
            'submission' => $submission,
            'message' => 'Submission graded successfully.'
        ]);
    }
}
