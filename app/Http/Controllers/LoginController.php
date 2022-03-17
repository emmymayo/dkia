<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\MultiDatabaseHandler;
use App\Models\User;
use App\Support\Helpers\Exam;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){

    
        if(Auth::attempt([
                'email' => $request->username,
                'password' => $request->password,
                'status' => 1,
            ],$request->remember))
        {
            $request->session()->regenerate() ;
            if(!$this->isStudentRegisteredForCurrentSession()){
                return redirect()->route('logout');
            }
            return redirect('dashboard');
            
        }else{
            $user = User::firstWhere('id',Student::select('user_id')->firstWhere('admin_no',$request->username) );
                        
            if($user && $user->status == 1){
                // Verify student password
                $user = $user->makeVisible(['password']);
                if(Hash::check($request->password,$user->password)){
                    Auth::loginUsingId($user->id);
                    $request->session()->regenerate();
                    $this->checkIfStudentRegisteredForCurrentSession();
                    return redirect('dashboard');
                } 
            }
        }

        return back()->withErrors(['error'=>'Credentials do no match our records.']);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');

    }

    public function isStudentRegisteredForCurrentSession(){
        // Check if student is registered for current session else logout
        if(Auth::user() && User::find(Auth::id())->isStudent()){
            $student_id = User::find(auth()->id())->student->id;
            
            $section = Exam::getStudentCurrentSection($student_id) ;
            
            // abort when the student hasnt been registered, promoted or has no section is for this session
            if(empty($section)){
                
               return false;
            }
             
        }
        return true;
    }
}
