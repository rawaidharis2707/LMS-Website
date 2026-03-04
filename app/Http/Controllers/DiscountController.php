<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Discount::query()->with('user');

        if ($user->role === 'student') {
            $query->where('user_id', $user->id);
        } elseif ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'amount' => 'nullable|numeric',
            'percentage' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $discount = Discount::create($validated);

        return response()->json(['success' => true, 'discount' => $discount, 'message' => 'Discount applied successfully.']);
    }

    public function update(Request $request, string $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request->all());

        return response()->json(['success' => true, 'message' => 'Discount updated.']);
    }

    public function destroy(string $id)
    {
        Discount::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
