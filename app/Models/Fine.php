<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    protected $fillable = [
        'user_id', 
        'category', 
        'amount', 
        'reason', 
        'date_issued', 
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date_issued' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
