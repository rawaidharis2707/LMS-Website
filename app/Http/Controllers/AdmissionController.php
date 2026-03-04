<?php

namespace App\Http\Controllers;

use App\Models\AdmissionRequest;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdmissionController extends Controller
{
    /**
     * Store a new admission application (public form submission).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'cnic' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'nationality' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'blood_group' => 'nullable|string|max:10',
            'mobile' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'required|email',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'class_applying' => 'required|string|max:100',
            'academic_part' => 'nullable|string|max:50',
            'prev_school' => 'nullable|string|max:255',
            'prev_board' => 'nullable|string|max:100',
            'prev_roll_no' => 'nullable|string|max:20',
            'marks_obtained' => 'nullable|numeric',
            'total_marks' => 'nullable|numeric',
            'percentage' => 'nullable|numeric',
            'voucher_id' => 'nullable|string|max:50',
            // Files (optional but validated if present)
            'studentPhoto' => 'sometimes|file|mimes:jpg,jpeg,png|max:2048',
            'feeReceipt' => 'sometimes|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'docStudentCnic' => 'sometimes|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'docGuardianCnic' => 'sometimes|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'docResultCard' => 'sometimes|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'docCharacterCert' => 'sometimes|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'docDomicile' => 'sometimes|file|mimes:jpg,jpeg,png,pdf|max:4096',
            ]);

            $applicationId = 'APP-' . date('Y') . '-' . str_pad((string) random_int(10000, 99999), 5, '0');
            $validated['application_id'] = $applicationId;
            $validated['payment_status'] = 'Unpaid';
            $validated['status'] = 'Pending Review';

            // Store uploaded files to public disk under admissions/{applicationId}
            $disk = 'public';
            $basePath = 'admissions/' . $applicationId;

            $paths = [];
            if ($request->hasFile('studentPhoto')) {
                $paths['photo_path'] = $request->file('studentPhoto')->store($basePath, $disk);
            }
            if ($request->hasFile('feeReceipt')) {
                $paths['fee_receipt_path'] = $request->file('feeReceipt')->store($basePath, $disk);
            }
            if ($request->hasFile('docStudentCnic')) {
                $paths['doc_student_cnic_path'] = $request->file('docStudentCnic')->store($basePath, $disk);
            }
            if ($request->hasFile('docGuardianCnic')) {
                $paths['doc_guardian_cnic_path'] = $request->file('docGuardianCnic')->store($basePath, $disk);
            }
            if ($request->hasFile('docResultCard')) {
                $paths['doc_result_card_path'] = $request->file('docResultCard')->store($basePath, $disk);
            }
            if ($request->hasFile('docCharacterCert')) {
                $paths['doc_character_cert_path'] = $request->file('docCharacterCert')->store($basePath, $disk);
            }
            if ($request->hasFile('docDomicile')) {
                $paths['doc_domicile_path'] = $request->file('docDomicile')->store($basePath, $disk);
            }

            $admission = AdmissionRequest::create(array_merge($validated, $paths));

            return response()->json([
                'success' => true,
                'application_id' => $admission->application_id,
                'message' => 'Application submitted successfully.',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error during submission',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * List admission requests (for admin).
     */
    public function index(Request $request)
    {
        $query = AdmissionRequest::query()->orderByDesc('created_at');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('full_name', 'like', "%{$term}%")
                    ->orWhere('application_id', 'like', "%{$term}%")
                    ->orWhere('father_name', 'like', "%{$term}%");
            });
        }

        $admissions = $query->get()->map(function ($a) {
            return [
                'id' => $a->id, // Use actual database ID instead of application_id
                'application_id' => $a->application_id,
                'fullName' => $a->full_name,
                'fatherName' => $a->father_name,
                'classApply' => $a->class_applying,
                'date' => $a->created_at->format('d-M-Y'),
                'voucherId' => $a->voucher_id,
                'paymentStatus' => $a->payment_status,
                'status' => $a->status,
                'dob' => $a->dob?->format('d-m-Y'),
                'cnic' => $a->cnic,
                'gender' => $a->gender,
                'mobile' => $a->mobile,
                'email' => $a->email,
                'address' => $a->present_address,
                'prevSchool' => $a->prev_school,
                'marksObtained' => $a->marks_obtained,
                'totalMarks' => $a->total_marks,
                'percentage' => $a->percentage,
                'docs' => [
                    'photo' => $a->photo_path ? asset('storage/'.$a->photo_path) : null,
                    'feeReceipt' => $a->fee_receipt_path ? asset('storage/'.$a->fee_receipt_path) : null,
                    'studentCnic' => $a->doc_student_cnic_path ? asset('storage/'.$a->doc_student_cnic_path) : null,
                    'guardianCnic' => $a->doc_guardian_cnic_path ? asset('storage/'.$a->doc_guardian_cnic_path) : null,
                    'resultCard' => $a->doc_result_card_path ? asset('storage/'.$a->doc_result_card_path) : null,
                    'characterCert' => $a->doc_character_cert_path ? asset('storage/'.$a->doc_character_cert_path) : null,
                    'domicile' => $a->doc_domicile_path ? asset('storage/'.$a->doc_domicile_path) : null,
                ],
            ];
        });

        return response()->json($admissions);
    }

    /**
     * Update admission status (approve/reject) and optionally payment status.
     */
    public function update(Request $request, string $id)
    {
        // Try to find by database ID first, then by application_id
        $admission = AdmissionRequest::where('id', $id)->first();
        if (!$admission) {
            $admission = AdmissionRequest::where('application_id', $id)->firstOrFail();
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:Pending Review,Admitted,Rejected',
            'payment_status' => 'sometimes|in:Paid,Unpaid',
        ]);

        if (! empty($validated['status'])) {
            $admission->status = $validated['status'];

            if ($validated['status'] === 'Admitted') {
                $existing = User::where('email', $admission->email)->first();
                if (! $existing) {
                    $schoolClass = SchoolClass::where('name', $admission->class_applying)->first();
                    
                    User::create([
                        'name' => $admission->full_name,
                        'email' => $admission->email,
                        'password' => Hash::make('123'),
                        'role' => 'student',
                        'enrolled_class' => $admission->class_applying,
                        'school_class_id' => $schoolClass?->id,
                        'roll_number' => $admission->application_id,
                    ]);
                }
            }
        }

        if (! empty($validated['payment_status'])) {
            $admission->payment_status = $validated['payment_status'];
        }

        $admission->save();

        return response()->json([
            'success' => true,
            'admission' => [
                'id' => $admission->application_id,
                'status' => $admission->status,
                'paymentStatus' => $admission->payment_status,
            ],
        ]);
    }
}
