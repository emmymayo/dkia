<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Support\Helpers\Exam;

class UserDashboardController extends Controller
{
    public function toUserDashboard(Request $request){
        if(User::find(Auth::id())->isAdmin()){
            return view('dashboards.main',[
               
                ]);
        }
        elseif(User::find(Auth::id())->isTeacher()){
            return view('dashboards.main');
        }
        elseif(User::find(Auth::id())->isStudent()){
            $student_id = User::find(auth()->id())->student->id;
            
            $section = Exam::getStudentCurrentSection($student_id) ;
            
            
            return view('dashboards.main', ['my_section'=> $section]);
        }
    }

}