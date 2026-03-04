<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Get quizzes.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Quiz::query()->with(['subject', 'questions']);

        if ($user->role === 'student') {
            $query->where('school_class_id', $user->school_class_id);
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    /**
     * Get quiz results for the user.
     */
    public function results(Request $request)
    {
        $user = $request->user();
        $query = QuizResult::query()->with(['quiz']);

        if ($user->role === 'student') {
            $query->where('user_id', $user->id);
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    /**
     * Store a new quiz (Admin/Teacher).
     */
    public function store(StoreQuizRequest $request)
    {
        $validated = $request->validated();

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'school_class_id' => $validated['school_class_id'],
            'subject_id' => $validated['subject_id'],
            'author_id' => $request->user()->id,
            'due_date' => $validated['due_date'],
            'duration_minutes' => $validated['duration_minutes'],
        ]);

        foreach ($validated['questions'] as $qData) {
            $quiz->questions()->create([
                'text' => $qData['text'],
                'options' => $qData['options'],
                'correct_option' => $qData['correct_option'],
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Quiz created successfully.']);
    }

    /**
     * Submit quiz results.
     */
    public function submit(Request $request, string $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $score = 0;
        $totalMarks = $quiz->questions->count();

        foreach ($quiz->questions as $idx => $question) {
            if (isset($validated['answers'][$idx]) && $validated['answers'][$idx] === $question->correct_option) {
                $score++;
            }
        }

        $result = QuizResult::create([
            'quiz_id' => $quiz->id,
            'user_id' => $request->user()->id,
            'score' => $score,
            'total_marks' => $totalMarks,
        ]);

        return response()->json([
            'success' => true,
            'score' => $score,
            'total' => $totalMarks,
            'message' => 'Quiz submitted successfully.'
        ]);
    }
}
