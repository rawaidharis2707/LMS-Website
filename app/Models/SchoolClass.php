<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = ['name', 'section', 'capacity', 'batch', 'level', 'group'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
