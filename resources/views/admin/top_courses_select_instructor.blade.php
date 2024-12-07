@extends('adminlte::page')

@section('title', 'Select Instructor')

@section('content_header')
    <h1>Instructor List</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Select Instructor</h3>
        </div>
        <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Instructor Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($instructors as $index => $instructor)
                            <tr>
                                <td>{{ $instructor->id }}</td>
                                <td>{{ $instructor->name }}</td>
                                <td>{{ $instructor->email }}</td>
                                <td><a href="{{ route('courses.top', [$instructor->id, $instructor->name]) }}" class="btn btn-success">Select</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
@stop
