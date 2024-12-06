<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        //Gate for the functionality only admins can use
        Gate::define('admin-only', function ($user) {
            return $user->role_id === 1; // Check if user is an admin
        });


        //Dynamic menu items for dashboard according to user role
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Check if the user is authenticated
            if (Auth::check()) {
                // Add items based on the user's role
                $user = Auth::user();

                // For Admin role
                if ($user->role_id == Role::ADMIN) {
                    $event->menu->add([
                        'text' => 'Admin Dashboard',
                        'url' => 'admin/dashboard',
                        'icon' => 'fas fa-tachometer-alt',
                    ]);
                    $event->menu->add('Users');
                    $event->menu->add([
                        'text' => 'Add Users',
                        'url' => 'admin/create_user',
                        'icon' => 'fas fa-fw fa-plus',
                    ]);
                    $event->menu->add([
                        'text' => 'View Users',
                        'url' => 'admin/user_list',
                        'icon' => 'fas fa-fw fa-user',
                    ]);
                }

                // For Instructor role
                elseif ($user->role_id == Role::INSTRUCTOR) {
                    $event->menu->add([
                        'text' => 'Dashboard',
                        'url' => 'instructor/dashboard',
                        'icon' => 'nav-icon fas fa-tachometer-alt',
                    ]);
                    $event->menu->add('Courses');
                    $event->menu->add([
                        'text' => 'Create Course',
                        'url' => 'instructor/create_course',
                        'icon' => 'fas fa-plus',
                    ]);
                    $event->menu->add([
                        'text' => 'My Courses',
                        'url' => 'instructor/course_list',
                        'icon' => 'fas fa-book',
                    ]);
                }

                // For Student role
                elseif ($user->role_id == Role::STUDENT) {
                    $event->menu->add([
                        'text' => 'Dashboard',
                        'url' => 'student/dashboard',
                        'icon' => 'nav-icon fas fa-tachometer-alt',
                    ]);
                    $event->menu->add('Courses');
                    $event->menu->add([
                        'text' => 'All Courses',
                        'url' => 'student/course_list',
                        'icon' => 'fas fa-book',
                    ]);
                    $event->menu->add([
                        'text' => 'My Course',
                        'url' => 'student/my_courses',
                        'icon' => 'fas fa-book',
                    ]);
                }
            } else {
                //exception for edge case of the guest.
                $event->menu->add('GUEST NAVIGATION');
                $event->menu->add([
                    'text' => 'Login',
                    'url' => 'login',
                    'icon' => 'fas fa-sign-in-alt',
                ]);
            }
        });
    }
}
