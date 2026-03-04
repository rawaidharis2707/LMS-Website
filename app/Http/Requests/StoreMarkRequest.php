<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['admin', 'teacher']);
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type' => 'required|string|in:Midterm,Final,Quiz,Assignment',
            'marks_obtained' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:1|max:100',
            'teacher_remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Student selection is required.',
            'user_id.exists' => 'Selected student does not exist.',
            'subject_id.required' => 'Subject selection is required.',
            'subject_id.exists' => 'Selected subject does not exist.',
            'exam_type.required' => 'Exam type is required.',
            'exam_type.in' => 'Exam type must be one of: Midterm, Final, Quiz, Assignment.',
            'marks_obtained.required' => 'Marks obtained is required.',
            'marks_obtained.numeric' => 'Marks obtained must be a number.',
            'marks_obtained.min' => 'Marks obtained cannot be negative.',
            'marks_obtained.max' => 'Marks obtained cannot exceed 100.',
            'total_marks.required' => 'Total marks is required.',
            'total_marks.min' => 'Total marks must be at least 1.',
            'total_marks.max' => 'Total marks cannot exceed 100.',
            'teacher_remarks.max' => 'Teacher remarks cannot exceed 500 characters.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'marks_obtained' => round($this->marks_obtained, 2),
            'total_marks' => round($this->total_marks, 2),
        ]);
    }
}
