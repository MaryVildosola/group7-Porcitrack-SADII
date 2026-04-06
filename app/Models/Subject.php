<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_name', 'name', 'code', 'description', 'is_active',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
