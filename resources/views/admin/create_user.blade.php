@extends('adminlte::page')

@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('content_header')
    <h1>{{ isset($user) ? 'Edit User' : 'Create User' }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">{{ isset($user) ? 'Edit User' : 'Add New User' }}</h3>
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

            <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST">
                @csrf

                @if (isset($user))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter user's name" value="{{ isset($user) ? $user->name : old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter user's email" value="{{ isset($user) ? $user->email : old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" {{ isset($user) ? '' : 'required' }}>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="confirm_password" class="form-control" placeholder="Re-enter password" {{ isset($user) ? '' : 'required' }}>
                </div>

                <div class="form-group">
                    <label>User Type</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="role_id" id="instructor" value="2" class="form-check-input" {{ isset($user) && $user->role_id == 2 ? 'checked' : '' }} required>
                            <label for="instructor" class="form-check-label">Instructor</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="role_id" id="student" value="3" class="form-check-input" {{ isset($user) && $user->role_id == 3 ? 'checked' : '' }}>
                            <label for="student" class="form-check-label">Student</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="role_id" id="admin" value="1" class="form-check-input" {{ isset($user) && $user->role_id == 1 ? 'checked' : '' }}>
                            <label for="admin" class="form-check-label">Admin</label>
                        </div>
                    </div>
                </div>

                <div class="form-footer text-right">
                    <button type="submit" class="btn btn-success">{{ isset($user) ? 'Update User' : 'Create User' }}</button>
                </div>
            </form>
        </div>
    </div>
@stop
