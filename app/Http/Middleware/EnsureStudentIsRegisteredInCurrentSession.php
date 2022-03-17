<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Support\Helpers\Exam;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStudentIsRegisteredInCurrentSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user() && User::find(Auth::id())->isStudent()){
            $student_id = User::find(auth()->id())->student->id;
            
            $section = Exam::getStudentCurrentSection($student_id) ;
            // abort when the student hasnt been registered, promoted or has no section is for this session
            if(empty($section)){
                redirect()->route('logout');
            }
            
            
            
        }
        return $next($request);
    }
}
