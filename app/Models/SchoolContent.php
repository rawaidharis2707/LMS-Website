<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolContent extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'type', 
        'file_path', 
        'school_class_id', 
        'subject_id', 
        'author_id', 
        'due_date'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'school_content_id');
    }
}
