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
                            <th>Enroll Using CSV</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $index => $course)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ Str::limit($course->description, 50) }}</td>
                                <td>
                                    <form action="{{route('courses.enroll_csv',$course->id)}}" method="POST" enctype="multipart/form-data" style="display: inline-block">
                                        @csrf
                                        <input type="file" name="csv_file" class="" required>
                                        <button type="submit" class="btn btn-primary float-right">Upload</button>
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
