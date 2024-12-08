@extends('adminlte::page')

@section('title', isset($course) ? 'Edit Course' : 'Create Course')

@section('content_header')
    <h1>{{ isset($course) ? 'Edit Course' : 'Create Course' }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">{{ isset($course) ? 'Edit Course' : 'Add New Course' }}</h3>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            <form action="{{ isset($course) ? route('course.update', $course->id) : route('course.store') }}" method="POST">
                @csrf

                @if (isset($course))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="title">Course Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter the course title" value="{{ isset($course) ? $course->title : old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Course Description</label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Enter a brief course description">{{ isset($course) ? $course->description : old('description') }}</textarea>
                </div>

                <div class="form-footer text-right">
                    <button type="submit" class="btn btn-success">{{ isset($course) ? 'Update Course' : 'Create Course' }}</button>
                </div>
            </form>
        </div>
    </div>
@stop
