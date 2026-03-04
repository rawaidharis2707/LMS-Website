<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarkRequest;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    /**
     * Get marks for student.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Mark::query()->with(['subject', 'subject.schoolClass']);

        if ($user->role === 'student') {
            $query->where('user_id', $user->id);
        } elseif ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    /**
     * Store marks in bulk.
     */
    public function store(StoreMarkRequest $request)
    {
        $validated = $request->validated();

        foreach ($validated['marks'] as $markData) {
            $markData['grade'] = $this->calculateGrade($markData['marks_obtained'], $markData['total_marks']);
            
            Mark::updateOrCreate(
                [
                    'user_id' => $markData['user_id'],
                    'subject_id' => $markData['subject_id'],
                    'exam_type' => $markData['exam_type'],
                ],
                $markData
            );
        }

        return response()->json(['success' => true, 'message' => 'Marks saved successfully.']);
    }

    private function calculateGrade($obtained, $total)
    {
        $perc = ($obtained / $total) * 100;
        if ($perc >= 80) return 'A+';
        if ($perc >= 70) return 'A';
        if ($perc >= 60) return 'B';
        if ($perc >= 50) return 'C';
        if ($perc >= 40) return 'D';
        return 'F';
    }
}
