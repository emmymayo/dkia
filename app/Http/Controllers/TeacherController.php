<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Admin;

use App\Models\Setting;
use App\Models\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Exception;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Teacher::class);
        
            return view('pages.teachers.index',[
                'data'=> User::with(['admin','role'])->where('id',Auth::id())->get()[0],
                'settings' => Setting::all(),
                'teachers' => Teacher::all(),
                ]);
    }
    public function assignTeacher(){
        return view('pages.teachers.assign.index');
    }

    public function getTeachers(){
        $this->authorize('viewAny', Teacher::class);
        $teachers = Teacher::all();
        return response()->json($teachers,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Admin::class);

        return view('pages.teachers.create',[
            'data'=> User::with(['admin','role'])->where('id',Auth::id())->get()[0],
            'settings' => Setting::all(),
            
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Teacher::class);
        //validate request
        $request->validate([
            'email' => 'bail|required|email:filter|unique:users,email',
            'password' => 'bail|required|min:6|confirmed',
            'name' => 'required|max:250',
            'gender' => 'required|max:6',
            'qualification' => 'nullable|max:50',
            'address' => 'nullable|max:250',
            'account' => 'nullable|max:200',
            'phone' => 'nullable|max:20',
            'photo' => 'nullable|file|image|max:1024|mimes:jpg,png'
        ]);
        
        try{

           $upload_success = DB::transaction( function() use($request) {
                    //retrieve teacher role
            $role = Role::where('name','teacher')->first();
            
            //create new user record
            $user = new User([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => $role->id
            ]);
            $user->save();
            $user->teacher()->save(new Teacher([
                'qualification' => $request->input('qualification')==null?'Nil':$request->input('qualification'),
                'gender' => $request->input('gender')==null?'Nil':$request->input('gender'),
                'phone' => $request->input('phone')==null?'Nil':$request->input('phone'),
                'address' => $request->input('address')==null?'Nil':$request->input('address'),
                'account' => $request->input('account')==null?'Nil':$request->input('account'),
            ]));

            if( !is_null($request->file('photo'))){
                $userId = $user->id;
                $extension = $request->photo->extension();
                $filename = $userId.".".$extension;
                $path = $request->photo->storeAs('images',$filename,'public');
                $user->avatar = $path;
                $user->save();
                return true;
            }else{return false;}
            
            
            },3);

        }catch(Exception $e){
            return back()->with('teacher-added-fail',"Something Went Wrong");
        }
        
        if($upload_success){back()->with('teacher-added-success','Teacher Added Successfully.'); }
        else {return back()->with('photo-upload-fail','Record Added Without Photo.');}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        $this->authorize('view',$teacher);

        return view('pages.teachers.profile',[
            'data'=> User::with(['admin','role'])->where('id',Auth::id())->get()[0],
            'settings' => Setting::all(),
            'profile' => $teacher,
            ]);
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $this->authorize('update', $teacher);
        //validate
        $request->validate([
            'name' => 'bail|required|max:250',
            'email' => 'email:filter',
            'gender' => 'required|max:6',
            'qualification' => 'max:50',
            'phone' => 'max:20',
            'address' => 'max:250',
            'account' => 'max:200',
        ]);
        $teacher->user->name= $request->input('name');
        $teacher->user->email = $request->input('email');
        $teacher->gender = $request->input('gender');
        $teacher->qualification = $request->input('qualification')==null?'Nil':$request->input('qualification');
        $teacher->phone = $request->input('phone')==null?'Nil':$request->input('phone');
        $teacher->address = $request->input('address')==null?'Nil':$request->input('address');
        $teacher->account = $request->input('account')==null?'Nil':$request->input('account');
        $saved = DB::transaction(function () use($teacher) {
            $teacher->user->save();
            return $teacher->save();
        },3);
        if($saved){
            return back()->with('profile-update-success','Teacher Profile Updated Successfully');
        }
        return back()->with('profile-update-fail','Something went wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $this->authorize('delete',$teacher);
        
        $name = $teacher->user->name;
        try{
            DB::transaction(function() use($teacher){
                $teacher->user->status = 0;
                $teacher->save();
                $teacher->user->delete();
                $teacher->delete();
            });
        }catch(Exception $e){
            return back()->with('user-delete-fail', 'Something went wrong. Try Again');
        }
       
        return back()->with('user-delete-success', $name.' Has Been Removed Successfully');
    }
}
