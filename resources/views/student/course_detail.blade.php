@extends('adminlte::page')

@section('title', 'Course Details')

@section('content_header')
    <h1>Course Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $course->title }}</h3>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <p><strong>Title:</strong> {{ $course->title }}</p>
            <p><strong>Description:</strong> {{ $course->description }}</p>
            <p><strong>Instructor:</strong> {{ $course->instructor->name }}</p>

            @if (!$isEnrolled)
                <!-- Check if the user is not already enrolled -->
                <form action="{{ route('course.enroll', $course->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary float-right">Enroll</button>
                </form>
            @else
                <!-- If the student is already enrolled -->
                <button class="btn btn-success float-right" disabled>Enrolled</button>
            @endif
        </div>
    </div>
@stop
