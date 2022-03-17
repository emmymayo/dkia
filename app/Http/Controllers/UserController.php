<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Update Photo to storage storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function uploadPhoto(Request $request, User $user)
    {
        if(User::find(Auth::id())->isAdmin() || $user->id = Auth::id() ){
            $request->validate([
                'photo' => 'bail|required|file|image|max:200|mimes:jpg,png'
            ]);
            if($request->file('photo')){
                $userId = $user->id;
                $extension = $request->photo->extension();
                $filename = $userId.".".$extension;
                $path = $request->photo->storeAs('images',$filename,'public');
                $user->avatar = $path;
                $user->save();
                return back()->with('photo-upload-success','Profile Picture Updated Successfully');
            }
            return back()->with('photo-upload-fail','Something went wrong. Try Again');
        }
        return abort(403);
        
    }

     /**
     * Reset User Password.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $user)
    {
        if(User::find(Auth::id())->isAdmin()){
            $user->password = Hash::make("password");
            $user->save();
            return back()->with('password-reset-success', 'Password Reset Successful');
        }
        return abort(403);
    }

     /**
     * Toggle User Status.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(User $user)
    {
        if(User::find(Auth::id())->isAdmin()){
            $user->status = $user->status==0? 1 : 0 ;
            $user->save();
            return back()->with('toggle-status-success', 'Status Change Successful');
        }
        return abort(403);
    }

     /**
     * Change user Password.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function changePassword(User $user, Request $request)
    {
        
        if(User::find(Auth::id())->isAdmin() || $user->id = Auth::id()){
            $request->validate([
                'current_password' => 'bail|required',
                'password' => 'required|min:6|confirmed'
            ]);
            
            if(Hash::check($request->input('current_password'),$user->password)){

                $user->password = Hash::make($request->input('password'));
                $user->save();
                return back()->with('change-password-success', 'Password Change Successful');
            }
            return back()->with('change-password-fail', 'Something went wrong. Try again later');
        }
        return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(User::find(Auth::id())->isAdmin()){
            $name = $user->name;
            $user->delete();
            return back()->with('user-delete-success', $name.'Has Been Removed Successfully');
        }
        return abort(403);
    }
}
