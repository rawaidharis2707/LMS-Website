<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    protected $fillable = [
        'school_content_id', 
        'user_id', 
        'file_path', 
        'student_comments', 
        'marks_obtained', 
        'teacher_feedback', 
        'status'
    ];

    protected $casts = [
        'marks_obtained' => 'decimal:2',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(SchoolContent::class, 'school_content_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
