<?php

namespace App\Http\Controllers;

use App\Models\FinanceTransaction;
use App\Models\ActivityLog;
use App\Models\AdmissionRequest;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\FeeVoucher;
use App\Models\Mark;
use App\Models\SchoolClass;
use App\Models\SchoolContent;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function superAdminDashboard()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalRevenue' => FinanceTransaction::where('type', 'credit')->where('status', '!=', 'Void')->sum('amount'),
            'totalExpenses' => FinanceTransaction::where('type', 'debit')->where('status', '!=', 'Void')->sum('amount'),
            'recentLogs' => ActivityLog::orderByDesc('created_at')->limit(5)->get(),
        ];

        return view('superadmin.dashboard', compact('stats'));
    }

    public function adminDashboard()
    {
        $stats = [
            'totalStudents' => User::where('role', 'student')->count(),
            'totalTeachers' => User::where('role', 'teacher')->count(),
            'pendingAdmissions' => AdmissionRequest::where('status', 'Pending Review')->count(),
            'totalClasses' => SchoolClass::count(),
            'feeCollection' => [
                'totalPaid' => FeeVoucher::where('status', 'Paid')->sum('amount'),
                'totalUnpaid' => FeeVoucher::where('status', 'Unpaid')->sum('amount'),
            ],
            'recentAnnouncements' => Announcement::orderByDesc('created_at')->limit(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function studentDashboard(Request $request)
    {
        $user = $request->user();
        
        // Calculate Attendance
        $totalDays = Attendance::where('user_id', $user->id)->count();
        $presentDays = Attendance::where('user_id', $user->id)->where('status', 'Present')->count();
        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 100;

        // Calculate Average Marks
        $averageMarks = Mark::where('user_id', $user->id)->avg('marks_obtained');

        $stats = [
            'announcementsCount' => Announcement::whereIn('target', ['all', 'students'])
                ->orWhere(function ($q) use ($user) {
                    $q->where('target', 'class')->where('target_value', $user->enrolled_class);
                })->count(),
            'pendingAssignments' => SchoolContent::where('type', 'assignment')
                ->where('school_class_id', $user->school_class_id)
                ->whereNotExists(function ($query) use ($user) {
                    $query->select('*')
                        ->from('submissions')
                        ->whereColumn('submissions.school_content_id', 'school_contents.id')
                        ->where('submissions.user_id', $user->id);
                })->count(),
            'attendance' => $attendancePercentage,
            'averageMarks' => round($averageMarks, 1) ?: 'N/A',
            'unpaidFees' => FeeVoucher::where('user_id', $user->id)->where('status', 'Unpaid')->count(),
        ];

        return view('student.dashboard', compact('stats'));
    }

    public function teacherDashboard(Request $request)
    {
        $user = $request->user();
        
        $assignedSubjectIds = $user->subjects()->pluck('id');
        $assignedClassIds = $user->subjects()->pluck('school_class_id')->unique();

        $stats = [
            'myClasses' => count($assignedClassIds),
            'totalStudents' => User::where('role', 'student')->whereIn('school_class_id', $assignedClassIds)->count(),
            'pendingSubmissions' => Submission::whereHas('assignment', function($q) use ($user) {
                $q->where('author_id', $user->id);
            })->where('status', 'submitted')->count(),
            'attendanceToday' => Attendance::whereIn('subject_id', $assignedSubjectIds)
                ->where('date', now()->toDateString())
                ->count() > 0 ? round((Attendance::whereIn('subject_id', $assignedSubjectIds)
                    ->where('date', now()->toDateString())
                    ->where('status', 'Present')
                    ->count() / Attendance::whereIn('subject_id', $assignedSubjectIds)
                    ->where('date', now()->toDateString())
                    ->count()) * 100) : 'N/A',
            'announcementsCount' => Announcement::whereIn('target', ['all', 'teachers'])->count(),
        ];

        return view('teacher.dashboard', compact('stats'));
    }
}
