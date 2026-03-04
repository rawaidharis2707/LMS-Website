<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\SchoolClass;

class PromotionController extends Controller
{
    /**
     * Promote a list of students to a target class.
     */
    public function promote(Request $request)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'target_class_id' => 'required|exists:school_classes,id',
        ]);

        $students = User::whereIn('id', $validated['student_ids'])->get();
        $targetClass = SchoolClass::findOrFail($validated['target_class_id']);

        foreach ($students as $student) {
            $student->school_class_id = $targetClass->id;
            $student->save();
        }

        return response()->json([
            'success' => true,
            'message' => count($students) . ' students promoted to ' . $targetClass->name
        ]);
    }
}
