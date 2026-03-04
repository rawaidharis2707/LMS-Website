<?php

namespace Database\Seeders;

use App\Models\AdmissionRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdmissionRequestSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admissions = [
            [
                'application_id' => 'APP-2024-001',
                'full_name' => 'Ahmed Hassan',
                'father_name' => 'Muhammad Hassan',
                'cnic' => '35202-1234567-1',
                'dob' => '2008-05-15',
                'gender' => 'Male',
                'nationality' => 'Pakistani',
                'religion' => 'Islam',
                'blood_group' => 'B+',
                'mobile' => '+92-300-1234567',
                'whatsapp' => '+92-300-1234567',
                'email' => 'ahmed.hassan@example.com',
                'present_address' => '123 Main Street, Lahore',
                'permanent_address' => '456 Home Avenue, Lahore',
                'class_applying' => 'Class 10-A',
                'academic_part' => 'Science',
                'prev_school' => 'City Grammar School',
                'prev_board' => 'Lahore Board',
                'prev_roll_no' => 'CGS-2023-123',
                'marks_obtained' => 450,
                'total_marks' => 550,
                'percentage' => 81.82,
                'voucher_id' => 'FEE-2024-001',
                'payment_status' => 'Paid',
                'status' => 'Pending Review',
                'photo_path' => null,
                'fee_receipt_path' => null,
                'doc_student_cnic_path' => null,
                'doc_guardian_cnic_path' => null,
                'doc_result_card_path' => null,
                'doc_character_cert_path' => null,
                'doc_domicile_path' => null,
            ],
            [
                'application_id' => 'APP-2024-002',
                'full_name' => 'Fatima Khan',
                'father_name' => 'Abdul Khan',
                'cnic' => '35202-9876543-2',
                'dob' => '2009-08-22',
                'gender' => 'Female',
                'nationality' => 'Pakistani',
                'religion' => 'Islam',
                'blood_group' => 'O+',
                'mobile' => '+92-321-9876543',
                'whatsapp' => '+92-321-9876543',
                'email' => 'fatima.khan@example.com',
                'present_address' => '786 Garden Road, Karachi',
                'permanent_address' => '123 Gulshan-e-Iqbal, Karachi',
                'class_applying' => 'Class 9-A',
                'academic_part' => 'Science',
                'prev_school' => 'Beaconhouse School',
                'prev_board' => 'Karachi Board',
                'prev_roll_no' => 'BHS-2023-456',
                'marks_obtained' => 420,
                'total_marks' => 500,
                'percentage' => 84.00,
                'voucher_id' => 'FEE-2024-002',
                'payment_status' => 'Unpaid',
                'status' => 'Pending Review',
                'photo_path' => null,
                'fee_receipt_path' => null,
                'doc_student_cnic_path' => null,
                'doc_guardian_cnic_path' => null,
                'doc_result_card_path' => null,
                'doc_character_cert_path' => null,
                'doc_domicile_path' => null,
            ],
            [
                'application_id' => 'APP-2024-003',
                'full_name' => 'Ali Raza',
                'father_name' => 'Raza Ahmed',
                'cnic' => '35202-4567890-3',
                'dob' => '2007-12-10',
                'gender' => 'Male',
                'nationality' => 'Pakistani',
                'religion' => 'Islam',
                'blood_group' => 'A+',
                'mobile' => '+92-333-4567890',
                'whatsapp' => '+92-333-4567890',
                'email' => 'ali.raza@example.com',
                'present_address' => '234 Mall Road, Rawalpindi',
                'permanent_address' => '567 Satellite Town, Rawalpindi',
                'class_applying' => 'Class 10-B',
                'academic_part' => 'Arts',
                'prev_school' => 'Froebel\'s School',
                'prev_board' => 'Rawalpindi Board',
                'prev_roll_no' => 'FRB-2023-789',
                'marks_obtained' => 380,
                'total_marks' => 500,
                'percentage' => 76.00,
                'voucher_id' => 'FEE-2024-003',
                'payment_status' => 'Paid',
                'status' => 'Admitted',
                'photo_path' => null,
                'fee_receipt_path' => null,
                'doc_student_cnic_path' => null,
                'doc_guardian_cnic_path' => null,
                'doc_result_card_path' => null,
                'doc_character_cert_path' => null,
                'doc_domicile_path' => null,
            ],
        ];

        foreach ($admissions as $admission) {
            AdmissionRequest::updateOrCreate(
                ['application_id' => $admission['application_id']],
                $admission
            );
        }
    }
}
