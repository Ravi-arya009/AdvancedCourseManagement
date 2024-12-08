@extends('adminlte::page')

@section('title', 'Available Courses')

@section('content_header')
    <h1>Available Courses</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">List of All Courses</h3>
        </div>
        <div class="card-body">
            @if ($courses->isEmpty())
                <p>No courses available.</p>
            @else
                <ul class="list-group">
                    @foreach ($courses as $course)
                        <li class="list-group-item mb-2">
                            <h5>{{ $course->title }}</h5>
                            <p>{{ $course->description }}</p>
                            <a href="{{ route('course.details', $course->id) }}" class="btn btn-primary float-right">View Details</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@stop
