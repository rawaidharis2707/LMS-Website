<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    /**
     * Get timetable entries.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Timetable::query()->with(['subject', 'teacher', 'schoolClass']);

        if ($user->role === 'student') {
            $query->where('school_class_id', $user->school_class_id);
        } elseif ($user->role === 'teacher') {
            $query->where('teacher_id', $user->id);
        } elseif ($request->has('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }

        return response()->json($query->get());
    }

    /**
     * Store a new timetable entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'nullable|string',
        ]);

        $timetable = Timetable::create($validated);

        return response()->json([
            'success' => true,
            'timetable' => $timetable->load(['subject', 'teacher', 'schoolClass']),
            'message' => 'Timetable entry created successfully.'
        ]);
    }

    /**
     * Delete a timetable entry.
     */
    public function destroy(string $id)
    {
        $timetable = Timetable::findOrFail($id);
        $timetable->delete();

        return response()->json(['success' => true]);
    }
}
