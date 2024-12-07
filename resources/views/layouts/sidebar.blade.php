@php
    use App\Models\Role;
@endphp

<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if (Auth::check())
                    @switch(Auth::user()->role_id)
                        @case(Role::ADMIN)
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Admin Dashboard</p>
                                </a>
                            </li>
                            <!-- Add other admin-specific menu items -->
                            @break

                        @case(Role::INSTRUCTOR)
                            <li class="nav-item">
                                <a href="{{ route('instructor.dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                    <p>pdiddy</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('course.list') }}" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>My Courses</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('course.create') }}" class="nav-link">
                                    <i class="nav-icon fas fa-plus"></i>
                                    <p>Create Course</p>
                                </a>
                            </li>
                            @break

                        @case(Role::STUDENT)
                            <li class="nav-item">
                                <a href="{{ route('student.dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Student Dashboard</p>
                                </a>
                            </li>
                            <!-- Add other student-specific menu items -->
                            @break
                    @endswitch
                @endif
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
