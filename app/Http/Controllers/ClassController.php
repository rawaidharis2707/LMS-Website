<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user && $user->role === 'teacher') {
            $classIds = \App\Models\Subject::where('teacher_id', $user->id)->pluck('school_class_id')->unique();
            return response()->json(SchoolClass::whereIn('id', $classIds)->get());
        }
        return response()->json(SchoolClass::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer',
            'batch' => 'nullable|string|max:100',
            'level' => 'nullable|string|max:100',
            'group' => 'nullable|string|max:100',
        ]);

        $schoolClass = SchoolClass::create($validated);

        return response()->json([
            'success' => true,
            'class' => $schoolClass,
            'message' => 'Class created successfully.'
        ]);
    }

    public function destroy(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $schoolClass->delete();

        return response()->json(['success' => true]);
    }
}
