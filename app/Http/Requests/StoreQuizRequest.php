<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['admin', 'teacher']);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'due_date' => 'nullable|date|after:now',
            'duration_minutes' => 'required|integer|min:5|max:180',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string|max:1000',
            'questions.*.options' => 'required|array|min:2|max:6',
            'questions.*.options.*' => 'required|string|max:255',
            'questions.*.correct_option' => 'required|string|in:A,B,C,D,E,F',
            'questions.*.points' => 'required|integer|min:1|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Quiz title is required.',
            'school_class_id.required' => 'Please select a class.',
            'school_class_id.exists' => 'Selected class does not exist.',
            'subject_id.required' => 'Please select a subject.',
            'subject_id.exists' => 'Selected subject does not exist.',
            'due_date.after' => 'Due date must be in the future.',
            'duration_minutes.min' => 'Duration must be at least 5 minutes.',
            'duration_minutes.max' => 'Duration cannot exceed 180 minutes.',
            'questions.required' => 'At least one question is required.',
            'questions.*.text.required' => 'Question text is required.',
            'questions.*.options.min' => 'Each question must have at least 2 options.',
            'questions.*.options.max' => 'Each question cannot have more than 6 options.',
            'questions.*.correct_option.in' => 'Correct option must be one of: A, B, C, D, E, F.',
            'questions.*.points.min' => 'Points must be at least 1.',
            'questions.*.points.max' => 'Points cannot exceed 10.',
        ];
    }
}
