<?php

namespace App\Http\Controllers;

use App\Models\FeeVoucher;
use Illuminate\Http\Request;

class FeeVoucherController extends Controller
{
    /**
     * Get fee vouchers for the current user.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = FeeVoucher::query()->with('user');

        if ($user->role === 'student') {
            $query->where('user_id', $user->id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('voucher_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('roll_number', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', ucfirst($request->status));
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
            'month' => 'required|string',
            'status' => 'nullable|in:Paid,Unpaid',
        ]);

        if (!isset($validated['status'])) {
            $validated['status'] = 'Unpaid';
        }
        
        $validated['voucher_id'] = 'V-' . date('Ymd') . '-' . random_int(1000, 9999);

        $voucher = FeeVoucher::create($validated);

        return response()->json([
            'success' => true,
            'voucher' => $voucher->load('user'),
            'message' => 'Fee voucher created successfully.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $voucher = FeeVoucher::findOrFail($id);
        
        $validated = $request->validate([
            'amount' => 'nullable|numeric',
            'due_date' => 'nullable|date',
            'status' => 'nullable|in:Paid,Unpaid',
        ]);

        $voucher->update($validated);

        return response()->json([
            'success' => true,
            'voucher' => $voucher->load('user'),
            'message' => 'Voucher updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $voucher = FeeVoucher::findOrFail($id);
        $voucher->delete();

        return response()->json(['success' => true, 'message' => 'Voucher deleted.']);
    }

    public function toggleStatus($id)
    {
        $voucher = FeeVoucher::findOrFail($id);
        $voucher->status = ($voucher->status === 'Paid') ? 'Unpaid' : 'Paid';
        $voucher->save();

        return response()->json(['success' => true, 'status' => $voucher->status]);
    }
}
