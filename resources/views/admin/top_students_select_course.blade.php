@extends('adminlte::page')

@section('title', 'Select Course')

@section('content_header')
    <h1>User List</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Select Course</h3>
        </div>
        <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Instructor</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($courses as $index => $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->instructor->name }}</td>
                                <td><a href="{{ route('students.top', [$course->id, $course->title]) }}" class="btn btn-success">Select</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
@stop
