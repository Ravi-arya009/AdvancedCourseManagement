<!DOCTYPE html>
<html>
<head>
    <title>Weekly Summary</title>
</head>
<body>
    <h1>Weekly Summary for {{ $course->title }}</h1>
    <p>Instructor: {{ $instructor->name }}</p>
    <h3>Student Grades:</h3>
    <ul>
        @foreach ($summary as $student)
            <li>
                <strong>Name:</strong> {{ $student['name'] }} |
                <strong>Email:</strong> {{ $student['email'] }} |
                <strong>Grade:</strong> {{ $student['grade'] }}
            </li>
        @endforeach
    </ul>
</body>
</html>
