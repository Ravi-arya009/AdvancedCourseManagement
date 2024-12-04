<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function create()
    {
        return view('create_course');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course = new Course();
        $course->title = $validated['title'];
        $course->description = $validated['description'];
        $course->instructor_id = Auth::id();
        $course->save();

        return redirect()->route('course.edit', $course->id)->with('success', 'Course created successfully!');
    }

    public function edit(Course $course)
    {
        return view('create_course', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course = Course::findOrFail($id);
        $course->title = $validated['title'];
        $course->description = $validated['description'];
        $course->save();

        return redirect()->route('course.edit', $course->id)->with('success', 'Course updated successfully!');
    }
}
