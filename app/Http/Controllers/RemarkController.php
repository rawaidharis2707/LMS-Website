<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use Illuminate\Http\Request;

class RemarkController extends Controller
{
    /**
     * Display a listing of remarks.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Remark::query()->with(['user', 'teacher']);

        if ($user->role === 'student') {
            $query->where('user_id', $user->id);
        } elseif ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->orderByDesc('date')->get());
    }

    /**
     * Store a newly created remark.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:Positive,Negative,Neutral',
            'text' => 'required|string',
            'date' => 'required|date',
        ]);

        $validated['teacher_id'] = $request->user()->id;

        $remark = Remark::create($validated);

        return response()->json(['success' => true, 'remark' => $remark, 'message' => 'Remark added successfully.']);
    }

    /**
     * Remove the specified remark.
     */
    public function destroy(string $id)
    {
        $remark = Remark::findOrFail($id);
        $remark->delete();

        return response()->json(['success' => true, 'message' => 'Remark deleted.']);
    }
}
