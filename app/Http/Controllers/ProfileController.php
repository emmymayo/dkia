<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function __invoke()
    {
        $user = User::find(Auth::id());
        if($user->isAdmin()){
            return redirect('/admins/'.$user->admin->id);
        }
        if($user->isTeacher()){
            return redirect('/teachers/'.$user->teacher->id);
        }
        if($user->isStudent()){
            return redirect('/students/'.$user->student->id);
        }
        return back();

    }
}
