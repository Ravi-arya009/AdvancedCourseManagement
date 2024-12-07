@extends('adminlte::page')

@section('title', 'Enrolled Students')

@section('content_header')
    <h1>Students Enrolled in
        {{ $course->title }}
    </h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Enrolled Students</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentsWithGrades as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <form action="{{ route('grade.update', $course) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="text" name="grade" value="{{ $student->grades->where('course_id', $course->id)->first()->grade ?? '' }}" class="form-control">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Save Grade</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>

            </form>
        </div>
    </div>
@stop
