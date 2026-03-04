<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Fine::query()->with('user');

        if ($user->role === 'student') {
            $query->where('user_id', $user->id);
        } elseif ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        } elseif ($request->has('roll_number')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('roll_number', $request->roll_number);
            });
        }

        return response()->json($query->orderByDesc('date_issued')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'reason' => 'nullable|string',
            'date_issued' => 'required|date',
        ]);

        $fine = Fine::create($validated);

        return response()->json(['success' => true, 'fine' => $fine, 'message' => 'Fine issued successfully.']);
    }

    public function update(Request $request, string $id)
    {
        $fine = Fine::findOrFail($id);
        $fine->update($request->only(['status']));

        return response()->json(['success' => true, 'message' => 'Fine status updated.']);
    }

    public function destroy(string $id)
    {
        Fine::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
