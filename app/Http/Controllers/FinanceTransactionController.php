<?php

namespace App\Http\Controllers;

use App\Models\FinanceTransaction;
use Illuminate\Http\Request;

class FinanceTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FinanceTransaction::query()->with('user');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        return response()->json($query->orderByDesc('date')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:credit,debit',
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'method' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->user()->id;

        $transaction = FinanceTransaction::create($validated);

        return response()->json([
            'success' => true,
            'transaction' => $transaction,
            'message' => 'Transaction recorded successfully.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = FinanceTransaction::findOrFail($id);
        
        $validated = $request->validate([
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'date' => 'nullable|date',
            'method' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Transaction updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = FinanceTransaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['success' => true, 'message' => 'Transaction deleted.']);
    }
}
