<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number', 'first_name', 'last_name', 'middle_name',
        'birthdate', 'gender', 'grade_level', 'section',
        'email', 'contact_number', 'address', 'photo', 'status',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
