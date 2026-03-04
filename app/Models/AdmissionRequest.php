<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'full_name',
        'father_name',
        'cnic',
        'dob',
        'gender',
        'nationality',
        'religion',
        'blood_group',
        'mobile',
        'whatsapp',
        'email',
        'present_address',
        'permanent_address',
        'class_applying',
        'academic_part',
        'prev_school',
        'prev_board',
        'prev_roll_no',
        'marks_obtained',
        'total_marks',
        'percentage',
        'voucher_id',
        'payment_status',
        'status',
        'photo_path',
        'fee_receipt_path',
        'doc_student_cnic_path',
        'doc_guardian_cnic_path',
        'doc_result_card_path',
        'doc_character_cert_path',
        'doc_domicile_path',
    ];

    protected $casts = [
        'dob' => 'date',
        'marks_obtained' => 'decimal:2',
        'total_marks' => 'decimal:2',
        'percentage' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
