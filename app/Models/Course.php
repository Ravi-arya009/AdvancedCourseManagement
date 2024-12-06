<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //

    use HasFactory;

    protected $fillable = ['title', 'description', 'instructor_id'];

    // Relationship with User
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function create()
    {
        return view('instructor.courses.create');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
