@extends('adminlte::page')

@section('title', 'Top Course')

@section('content_header')
    <h1>Instructor name: {{ $instructorName }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Top Course</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    @if ($hasCourse==0)
                        <tr>
                            <td>Course Hasn't been graded yet</td>
                        </tr>
                    @else
                        <tr>
                            <th>Course Id</th>
                            <th>Course Name</th>
                            <th>Average Grade</th>
                        </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{ $topcourse->course_id }}</td>
                        <td>{{ $topcourse->course_title }}</td>
                        <td>{{ $topcourse->average_grade }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
