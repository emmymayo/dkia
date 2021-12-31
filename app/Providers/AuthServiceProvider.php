<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Admin' => 'App\Policies\AdminPolicy',
        'App\Models\Teacher' => 'App\Policies\TeacherPolicy',
        'App\Models\Student' => 'App\Policies\StudentPolicy',
        'App\Models\Classes' => 'App\Policies\ClassesPolicy',
        'App\Models\Section' => 'App\Policies\SectionPolicy',
        'App\Models\Exam' => 'App\Policies\ExamPolicy',
        'App\Models\Subject' => 'App\Policies\SubjectPolicy',
        'App\Models\Pin' => 'App\Policies\PinPolicy',
        'App\Models\Setting' => 'App\Policies\SettingPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('super-only', function(User $user){
            if( $user->role->name == 'super'){
                return true;
            }else{return false;}
        });
        Gate::define('admin-only', function(User $user){
            if($user->role->name == 'admin' OR $user->role->name == 'super'){
                return true;
            }else{return false;}
        });
        Gate::define('admin-and-teacher-only', function(User $user){
            if($user->role->name == 'admin' OR $user->role->name == 'super' OR $user->role->name == 'teacher'){
                return true;
            }else{return false;}
        });

        Gate::define('teacher-only', function(User $user){
            if($user->role->name == 'teacher' ){
                return true;
            }else{return false;}
        });

        Gate::define('teacher-and-student-only', function(User $user){
            if($user->role->name == 'teacher' OR $user->role->name == 'student'){
                return true;
            }else{return false;}
        });

        Gate::define('student-only', function(User $user){
            if($user->role->name == 'student' ){
                return true;
            }else{return false;}
        });
        //
    }
}
