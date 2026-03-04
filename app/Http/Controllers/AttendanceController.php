<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::query()->with(['user', 'subject']);
        
        if ($request->has('user_id')) {
            $query->forUser($request->user_id);
        }
        
        if ($request->has('date')) {
            $query->forDate($request->date);
        }

        if ($request->has('subject_id')) {
            $query->forSubject($request->subject_id);
        }

        if ($request->has('class_id')) {
            $query->forClass($request->class_id);
        }

        if ($request->has('role')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        return response()->json($query->orderByDesc('date')->get());
    }

    public function storeBatch(StoreAttendanceRequest $request)
    {
        $validated = $request->validated();
        
        $attendances = [];
        foreach ($validated['attendances'] as $attendanceData) {
            $attendances[] = array_merge($attendanceData, [
                'date' => $validated['date'],
                'subject_id' => $validated['subject_id'],
            ]);
        }
        
        Attendance::insert($attendances);
        
        return response()->json(['success' => true, 'message' => 'Attendance recorded successfully.']);
    }
}
