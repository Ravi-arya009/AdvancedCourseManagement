@extends('adminlte::page')

@section('title', 'My Courses')

@section('content_header')
    <h1>My Courses</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Course List</h3>
        </div>
        <div class="card-body">
            @if ($courses->isEmpty())
                <p>No courses found. <a href="{{ route('course.create') }}">Create a course</a> now!</p>
            @else
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $index => $course)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ Str::limit($course->description, 50) }}</td>
                                <td>
                                    <a href="{{route('course.view_students', $course->id)}}" class="btn btn-success">View Students</a>
                                    <a href="{{ route('course.edit', $course->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('course.delete', $course->id) }}" method="POST" style="display: inline-block;" class="float-right">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop
