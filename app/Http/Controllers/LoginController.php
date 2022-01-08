<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\MultiDatabaseHandler;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){

            if(Auth::attempt([
                    'email' => $request->username,
                    'password' => $request->password,
                    'status' => '1',
                ],$request->remember))
            {
                $request->session()->regenerate() ;
                
                return redirect('dashboard');
                
            }else{
                $user = User::firstWhere('id',Student::firstWhere('admin_no',$request->username)->pluck('user_id') )
                            ->makeVisible(['password']);
                if($user){
                    // Verify student password
                    if(Hash::check($request->password,$user->password)){
                        Auth::loginUsingId($user->id);
                        $request->session()->regenerate();
                
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
}
