<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    protected $fillable = [
        'student_id',
        'course_id',
        'enrollment_date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'student_id', 'student_id')
        ->where('course_id', $this->course_id);
    }
}
