<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['admin', 'teacher']);
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
            'attendances' => 'required|array|min:1',
            'attendances.*.user_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|string|in:Present,Absent,Late,Excused',
            'attendances.*.remarks' => 'nullable|string|max:200',
            'attendances.*.check_in' => 'nullable|date_format:H:i',
            'attendances.*.check_out' => 'nullable|date_format:H:i|after:attendances.*.check_in',
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Date is required.',
            'date.date' => 'Please provide a valid date.',
            'subject_id.required' => 'Subject selection is required.',
            'subject_id.exists' => 'Selected subject does not exist.',
            'attendances.required' => 'At least one attendance record is required.',
            'attendances.*.user_id.required' => 'Student ID is required.',
            'attendances.*.user_id.exists' => 'Selected student does not exist.',
            'attendances.*.status.required' => 'Attendance status is required.',
            'attendances.*.status.in' => 'Status must be one of: Present, Absent, Late, Excused.',
            'attendances.*.remarks.max' => 'Remarks cannot exceed 200 characters.',
            'attendances.*.check_in.date_format' => 'Check-in time must be in HH:MM format.',
            'attendances.*.check_out.date_format' => 'Check-out time must be in HH:MM format.',
            'attendances.*.check_out.after' => 'Check-out time must be after check-in time.',
        ];
    }
}
