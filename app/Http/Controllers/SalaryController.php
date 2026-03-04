<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\User;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = Salary::query()->with('user');
        
        if ($request->has('month')) {
            $query->where('month', $request->month);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'base_salary' => 'required|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'month' => 'required|string',
            'status' => 'nullable|in:Paid,Unpaid',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
        ]);

        $allowances = $validated['allowances'] ?? 0;
        $deductions = $validated['deductions'] ?? 0;
        $validated['net_salary'] = $validated['base_salary'] + $allowances - $deductions;

        $salary = Salary::create($validated);

        return response()->json([
            'success' => true,
            'salary' => $salary->load('user'),
            'message' => 'Salary record created successfully.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:Paid,Unpaid',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
        ]);

        $salary->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Salary status updated.'
        ]);
    }

    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);
        $salary->delete();

        return response()->json(['success' => true, 'message' => 'Salary record deleted.']);
    }
}
