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
}
