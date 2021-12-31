<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Exception;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Admin::class);
            return view('pages.admins.index',[
                'admins' => Admin::all(),
                ]);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Admin::class);

            return view('pages.admins.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Admin::class);
        //validate request
        $request->validate([
            'email' => 'bail|required|email:filter|unique:users,email',
            'password' => 'bail|required|min:6|confirmed',
            //'password_confirmation' => 'bail|required|min:6|same:password',
            'name' => 'required|max:250',
            'position' => 'nullable',
            'contact' => 'nullable',
            'phone' => 'nullable|max:20',
            'photo' => 'nullable|file|image|max:1024|mimes:jpg,png'
        ]);
        try{
            $upload_success = DB::transaction( function() use($request) {
                    //retrieve admin role
            $role = Role::firstWhere('name','admin');
            
            //create new user record
            $user = new User([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => $role->id
            ]);
            $user->save();
            $user->admin()->save(new Admin([
                'position' => $request->input('position')==null?'Nil':$request->input('position'),
                'contact' => $request->input('contact')==null?'Nil':$request->input('contact'),
                'phone' => $request->input('phone')==null?'Nil':$request->input('phone'),
            ]));

            if( !is_null($request->file('photo'))){
                $userId = $user->id;
                $extension = $request->photo->extension();
                $filename = $userId.".".$extension;
                $path = $request->photo->storeAs('images',$filename,'public');
                $user->avatar = $path;
                return $user->save();
                
                
            }else{return false;}
            
            });
        }catch(Exception $e){
            back()->with('admin-added-fail', 'Something went wrong. Try again later.');
        }
        if($upload_success){return back()->with('admin-added-success', 'Admin Added Successfully');}
        else{return back()->with('photo-upload-fail','Record Added Without Photo.');}
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        $this->authorize('view',$admin);

            return view('pages.admins.profile',[
                'profile' => $admin,
                ]);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $this->authorize('update', $admin);
        //validate
        $request->validate([
            'name' => 'bail|required|max:250',
            'email' => 'email:filter'
        ]);
        $admin->user->name= $request->input('name');
        $admin->user->email = $request->input('email');
        $admin->position = $request->input('position')==null?'Nil':$request->input('position');
        $admin->contact = $request->input('contact')==null?'Nil':$request->input('contact');
        $admin->phone = $request->input('phone')==null?'Nil':$request->input('phone');
        $saved = DB::transaction(function() use($admin){
            $admin->user->save();
            return $admin->save();
        },3);
        if($saved){
            return back()->with('profile-update-success','Admin Profile Updated Successfully');
        }
        return back()->with('profile-update-fail','Something went wrong.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $this->authorize('delete',$admin);
        if($admin->user_id == 1 ){
            return back()->with('user-delete-fail', 'Something went wrong. Try Again');
        }
        $name = $admin->user->name;
        try{
            DB::transaction(function() use($admin){
                $admin->user->status = 0;
                $admin->save();
                $admin->user->delete();
                $admin->delete();
            });
        }catch(Exception $e){
            return back()->with('user-delete-fail', 'Something went wrong. Try Again');
        }
       
        return back()->with('user-delete-success', $name.' Has Been Removed Successfully');
    }

     /**
     * Upload photo for User storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
   
}
