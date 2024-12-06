<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
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

    public function list()
    {
        $instructorId = Auth::id();
        $courses = Course::where('instructor_id', $instructorId)->get();
        return view('course_list', compact('courses'));
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);

        if ($course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $course->delete();

        return redirect()->route('course.list')->with('success', 'Course deleted successfully.');
    }



    public function index()
    {
        $courses = Course::all();

        return view('student.course_list', compact('courses'));
    }

    public function details($id)
    {
        $course = Course::findOrFail($id);

        $isEnrolled = Enrollment::where('course_id', $course->id)
            ->where('student_id', Auth::id())
            ->exists();
        return view('student.course_detail', compact('course', 'isEnrolled'));
    }



    public function enroll(Course $course)
    {
        // Check if the user is already enrolled in the course
        if (Enrollment::where('course_id', $course->id)->where('student_id', Auth::id())->exists()) {
            return redirect()->route('course.details', $course->id)->with('error', 'You are already enrolled in this course.');
        }

        // Enroll the student in the course
        Enrollment::create([
            'course_id' => $course->id,
            'student_id' => Auth::id(),
            'enrollment_date' => now(),
        ]);

        return redirect()->route('course.details', $course->id)->with('success', 'You have successfully enrolled in the course.');
    }

    public function myCourses()
    {
        $enrolledCourses = Enrollment::where('student_id', Auth::id())
        ->with(['course', 'grade'])
        ->get();

        return view('student.enrolled_courses', compact('enrolledCourses'));
    }



    public function viewStudents(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $course = Course::find($course->id);
        $studentsWithGrades = $course->students()->with('grades')->get();

        return view('instructor.enrolled_students', compact('studentsWithGrades', 'course'));
    }

    public function updateGrades(Request $request, Course $course)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'grade' => 'nullable'
        ]);

        Grade::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'course_id' => $course->id
            ],
            [
                'grade' => $validated['grade']
            ]
        );

        return back()->with('success', 'Grade updated successfully');
    }


    public function home()
    {
        return view('home');
    }
}
