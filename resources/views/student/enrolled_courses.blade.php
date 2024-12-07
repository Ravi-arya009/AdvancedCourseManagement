@extends('adminlte::page')

@section('title', 'My Courses')

@section('content_header')
    <h1>My Courses</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Enrolled Courses</h3>
        </div>
        <div class="card-body">
            @if ($enrolledCourses->isEmpty())
                <p>You are not enrolled in any courses yet.</p>
            @else
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Instructor</th>
                            <th>Grades</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enrolledCourses as $enrollment)
                            <tr>
                                <td>{{ $enrollment->course->title }}</td>
                                <td>{{ $enrollment->course->description }}</td>
                                <td>{{ $enrollment->course->instructor->name }}</td>
                                <td>
                                    {{ $enrollment->course->grades->first()->grade ?? '-' }}
                                </td>


                                <td>
                                    <a href="{{ route('course.details', $enrollment->course->id) }}" class="btn btn-info">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop
