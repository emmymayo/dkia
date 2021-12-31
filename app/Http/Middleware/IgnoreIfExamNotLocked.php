<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\Helpers\Exam as ExamHelper;

class IgnoreIfExamNotLocked
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
        if(!ExamHelper::isExamLocked()){
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
