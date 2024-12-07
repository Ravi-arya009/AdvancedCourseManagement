<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use App\Notifications\GradeUpdated;
use App\Notifications\StudentEnrolled;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    use Notifiable;

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
        // Checking if the user is already enrolled in the course
        if (Enrollment::where('course_id', $course->id)->where('student_id', Auth::id())->exists()) {
            return redirect()->route('course.details', $course->id)->with('error', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'course_id' => $course->id,
            'student_id' => Auth::id(),
            'enrollment_date' => now(),
        ]);

        //sending notification after enrollment
        Notification::send(Auth::user(), new StudentEnrolled($course));

        //forgeting the cache after enrollment.
        Cache::forget("course_{$course->id}_students_with_grades");

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

        //using caching. if not cached then fetching from the database.
        $cacheKey = "course_{$course->id}_students_with_grades";

        $studentsWithGrades = Cache::remember($cacheKey, 60, function () use ($course) {
            return $course->students()->with('grades')->get();
        });

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

        $student = User::all()->where('id', $validated['student_id']);

        //sending notification after grade update
        Notification::send($student, new GradeUpdated($course, $validated['grade']));

        return back()->with('success', 'Grade updated successfully');
    }

    public function home()
    {
        return view('home');
    }

    public function temp()
    {
        $courses = Course::with(['instructor', 'grades'])->get();
        $count = 0;
        foreach ($courses as $course) {
            $instructor = $course->instructor;

            if ($instructor) {
                $count++;
                $summary = $course->students->map(function ($student) use ($course) {
                    $grade = $student->grades->where('course_id', $course->id)->first();
                    return [
                        'name' => $student->name,
                        'email' => $student->email,
                        'grade' => $grade ? $grade->grade : 'N/A',
                    ];
                });
            }
            dump($instructor->id);
            dump($course->title);
            dump($summary);
        }
    }

    ##########################
    #####Complex Queries#####
    #########################

    //top students for specific course.
    public function top_students_select_course()
    {
        $courses = Course::with(['instructor'])->get();
        return view('admin.top_students_select_course', compact('courses'));
    }
    public function top_students_view($courseId, $courseName)
    {
        $query = "SELECT users.id, users.name, grades.grade
        FROM enrollments
        JOIN users ON enrollments.student_id = users.id
        LEFT JOIN grades ON enrollments.student_id = grades.student_id AND enrollments.course_id = grades.course_id
        WHERE enrollments.course_id = ?
        ORDER BY CAST(grades.grade AS UNSIGNED) DESC
        LIMIT 5";

        $topstudents = DB::select($query, [$courseId]);
        return view('admin.top_students', compact('topstudents', 'courseName'));
    }

    //top course based on average grade
    public function top_courses_select_instructor()
    {
        $instructors = User::all()->where('role_id', 2);
        return view('admin.top_courses_select_instructor', compact('instructors'));
    }

    ##########################
    ######CSV Enrollment######
    #########################

    public function top_course_view($instructorId, $instructorName)
    {
        $query = "SELECT c.id AS course_id,c.title AS course_title,
        AVG(CAST(g.grade AS UNSIGNED)) AS average_grade
        FROM courses c
        JOIN enrollments e ON c.id = e.course_id
        JOIN grades g ON e.student_id = g.student_id AND c.id = g.course_id
        WHERE c.instructor_id = ?
        GROUP BY c.id, c.title
        ORDER BY average_grade DESC
        LIMIT 1";

        $topcourse = DB::select($query, [$instructorId]);
        $hasCourse = 1;
        if ($topcourse) {
            $topcourse = $topcourse[0];
        } else {
            $hasCourse = 0;
        }

        return view('admin.top_course', compact('topcourse', 'instructorName', 'hasCourse'));
    }


    public function csv_course_list()
    {
        $instructorId = Auth::id();
        $courses = Course::where('instructor_id', $instructorId)->get();
        return view('instructor.csv_course_list', compact('courses'));
    }

    public function enrollCSV(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        $headers = array_shift($data);
        foreach ($data as $row) {
            $studentData = array_combine($headers, $row);

            $student = User::firstOrCreate(
                ['email' => $studentData['email']],
                [
                    'name' => $studentData['name'],
                    'role_id' => 3,
                    'password' => Hash::make('12345678'),
                ]
            );

            Enrollment::firstOrCreate([
                'student_id' => $student->id,
                'course_id' => $course->id,
            ]);
        }

        return redirect()->route('course.view_students', $course->id)
            ->with('success', ' students enrolled successfully.');
    }
}
