<?php

use App\Http\Controllers\RemarkController;
use App\Http\Controllers\FinanceTransactionController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FeeVoucherController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SchoolContentController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Auth Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/user', [AuthController::class, 'user'])->name('user');
// Fallback for pages that don't include CSRF meta; keeps UX smooth while we migrate all views
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

Route::view('/admission', 'admission')->name('admission');

Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');

// API Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/api/admissions', [AdmissionController::class, 'index']);
    Route::patch('/api/admissions/{id}', [AdmissionController::class, 'update']);

    // Profile
    Route::patch('/api/profile', [ProfileController::class, 'update']);

    // Announcements
    Route::get('/api/announcements', [AnnouncementController::class, 'index']);
    Route::post('/api/announcements', [AnnouncementController::class, 'store']);
    Route::delete('/api/announcements/{id}', [AnnouncementController::class, 'destroy']);

    // Attendance
    Route::get('/api/attendance', [AttendanceController::class, 'index']);
    Route::post('/api/attendance/batch', [AttendanceController::class, 'storeBatch']);

    // Classes & Subjects
    Route::get('/api/classes', [ClassController::class, 'index']);
    Route::post('/api/classes', [ClassController::class, 'store']);
    Route::delete('/api/classes/{id}', [ClassController::class, 'destroy']);
    Route::get('/api/subjects', [SubjectController::class, 'index']);
    Route::post('/api/subjects', [SubjectController::class, 'store']);
    Route::delete('/api/subjects/{id}', [SubjectController::class, 'destroy']);

    // Users
    Route::get('/api/users', function (\Illuminate\Http\Request $request) {
        $query = \App\Models\User::query();
        if ($request->has('role')) $query->where('role', $request->role);
        if ($request->has('class_id')) $query->where('school_class_id', $request->class_id);
        return response()->json($query->get());
    });
    Route::get('/api/teachers', function () {
        return response()->json(\App\Models\User::where('role', 'teacher')->get());
    });
    Route::get('/api/students', function (\Illuminate\Http\Request $request) {
        $query = \App\Models\User::where('role', 'student');
        if ($request->has('class_id')) $query->where('school_class_id', $request->class_id);
        return response()->json($query->get());
    });

    // Salaries
    Route::get('/api/salaries', [SalaryController::class, 'index']);
    Route::post('/api/salaries', [SalaryController::class, 'store']);
    Route::patch('/api/salaries/{id}', [SalaryController::class, 'update']);
    Route::delete('/api/salaries/{id}', [SalaryController::class, 'destroy']);

    // Dashboard Views
    Route::get('/superadmin/dashboard', [DashboardController::class, 'superAdminDashboard'])->name('superadmin.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');
    Route::get('/teacher/dashboard', [DashboardController::class, 'teacherDashboard'])->name('teacher.dashboard');

    // Activity Logs
    Route::get('/api/activity-logs', function() {
        return response()->json(\App\Models\ActivityLog::orderByDesc('created_at')->limit(50)->get());
    });

    // Finance Transactions
    Route::get('/api/transactions', [FinanceTransactionController::class, 'index']);
    Route::post('/api/transactions', [FinanceTransactionController::class, 'store']);
    Route::patch('/api/transactions/{id}', [FinanceTransactionController::class, 'update']);
    Route::delete('/api/transactions/{id}', [FinanceTransactionController::class, 'destroy']);

    // Content (Notes, Assignments, etc.)
    Route::get('/api/content', [SchoolContentController::class, 'index']);
    Route::post('/api/content', [SchoolContentController::class, 'store']);
    Route::delete('/api/content/{id}', [SchoolContentController::class, 'destroy']);

    // Fees
    Route::get('/api/fees', [FeeVoucherController::class, 'index']);
    Route::post('/api/fees', [FeeVoucherController::class, 'store']);
    Route::patch('/api/fees/{id}', [FeeVoucherController::class, 'update']);
    Route::delete('/api/fees/{id}', [FeeVoucherController::class, 'destroy']);
    Route::patch('/api/fees/{id}/toggle-status', [FeeVoucherController::class, 'toggleStatus']);

    // Promotions
    Route::post('/api/promote', [PromotionController::class, 'promote']);

    // Fines
    Route::get('/api/fines', [FineController::class, 'index']);
    Route::post('/api/fines', [FineController::class, 'store']);
    Route::patch('/api/fines/{id}', [FineController::class, 'update']);
    Route::delete('/api/fines/{id}', [FineController::class, 'destroy']);

    // Discounts
    Route::get('/api/discounts', [DiscountController::class, 'index']);
    Route::post('/api/discounts', [DiscountController::class, 'store']);
    Route::patch('/api/discounts/{id}', [DiscountController::class, 'update']);
    Route::delete('/api/discounts/{id}', [DiscountController::class, 'destroy']);

    // Marks
    Route::get('/api/marks', [MarkController::class, 'index']);
    Route::post('/api/marks', [MarkController::class, 'store']);

    // Timetable
    Route::get('/api/timetable', [TimetableController::class, 'index']);
    Route::post('/api/timetable', [TimetableController::class, 'store']);
    Route::delete('/api/timetable/{id}', [TimetableController::class, 'destroy']);

    // Remarks
    Route::get('/api/remarks', [RemarkController::class, 'index']);
    Route::post('/api/remarks', [RemarkController::class, 'store']);
    Route::delete('/api/remarks/{id}', [RemarkController::class, 'destroy']);

    // Submissions
    Route::get('/api/submissions', [SubmissionController::class, 'index']);
    Route::post('/api/submissions', [SubmissionController::class, 'store']);
    Route::patch('/api/submissions/{id}/grade', [SubmissionController::class, 'grade']);

    // Quizzes
    Route::get('/api/quizzes', [QuizController::class, 'index']);
    Route::get('/api/quizzes/results', [QuizController::class, 'results']);
    Route::post('/api/quizzes', [QuizController::class, 'store']);
    Route::post('/api/quizzes/{id}/submit', [QuizController::class, 'submit']);
});

// Admin section
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/dashboard.html', [DashboardController::class, 'adminDashboard']);
    Route::view('/admissions.html', 'admin.admissions');
    Route::view('/admissions', 'admin.admissions')->name('admin.admissions');
    Route::view('/announcements.html', 'admin.announcements');
    Route::view('/announcements-input.html', 'admin.announcements');
    Route::view('/class-management.html', 'admin.class-management');
    Route::view('/data-correction.html', 'admin.data-correction');
    Route::view('/discount-management.html', 'admin.discount-management');
    Route::view('/fee-vouchers.html', 'admin.fee-vouchers');
    Route::view('/fines.html', 'admin.fines');
    Route::view('/student-promotion.html', 'admin.student-promotion');
    Route::view('/subject-assignment.html', 'admin.subject-assignment');
    Route::view('/teacher-attendance.html', 'admin.teacher-attendance');
    Route::view('/timetable-input.html', 'admin.timetable-input');
});

// Student section
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');
    Route::get('/dashboard.html', [DashboardController::class, 'studentDashboard']);
    Route::view('/profile.html', 'student.profile');
    Route::view('/subjects.html', 'student.subjects');
    Route::view('/timetable.html', 'student.timetable');
    Route::view('/attendance.html', 'student.attendance');
    Route::view('/results.html', 'student.results');
    Route::view('/assignments.html', 'student.assignments');
    Route::view('/quizzes.html', 'student.quizzes');
    Route::view('/notes.html', 'student.notes');
    Route::view('/lectures.html', 'student.lectures');
    Route::view('/announcements.html', 'student.announcements');
    Route::view('/fees.html', 'student.fees');
    Route::view('/fines.html', 'student.fines');
    Route::view('/fee-vouchers.html', 'student.fee-vouchers');
    Route::view('/print-voucher.html', 'student.print-voucher');
});

// Teacher section
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'teacherDashboard'])->name('teacher.dashboard');
    Route::get('/dashboard.html', [DashboardController::class, 'teacherDashboard']);
    Route::view('/marks-input.html', 'teacher.marks-input');
    Route::view('/remarks.html', 'teacher.remarks');
    Route::view('/upload-assignments.html', 'teacher.upload-assignments');
    Route::view('/upload-notes.html', 'teacher.upload-notes');
    Route::view('/upload-lectures.html', 'teacher.upload-lectures');
    Route::view('/create-quiz.html', 'teacher.create-quiz');
    Route::view('/attendance-input.html', 'teacher.attendance-input');
    Route::view('/my-attendance.html', 'teacher.my-attendance');
    Route::view('/timetable.html', 'teacher.timetable');
    Route::view('/announcements.html', 'teacher.announcements');
});

// Superadmin section
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::view('/dashboard', 'superadmin.dashboard')->name('superadmin.dashboard');
    Route::view('/dashboard.html', 'superadmin.dashboard');
    Route::view('/announcements.html', 'superadmin.announcements');
    Route::view('/role-distribution.html', 'superadmin.role-distribution');
    Route::view('/finance.html', 'superadmin.finance');
    Route::view('/salary.html', 'superadmin.salary');
    Route::view('/teacher-attendance.html', 'superadmin.teacher-attendance');
    Route::view('/reports.html', 'superadmin.reports');
    Route::view('/activity-logs.html', 'superadmin.activity-logs');
});
