<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassType;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Classes::class);

        $auth_user = Auth::user();
        
        
            return view('pages.classes.index',[
                'data'=> User::with([$auth_user->role->name,'role'])->where('id',Auth::id())->get()[0],
                'classes' => Classes::all(),
                'class_types' => ClassType::all(),
                
                ]);
    }

    public function getClasses()
    {
        return response()->json(Classes::all(),200);
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
        $this->authorize('create', Classes::class);

        $request->validate([
            'name'=>'required|max:50|unique:classes,name',
            'class_category' => 'required',
        ]);

        $classes = new Classes([
            'name' => $request->input('name'),
            'class_type_id' => $request->input('class_category'),
        ]);
        $classes->save();

        return back()->with('class-added-success',$request->input('name').' has been successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $classes)
    {
        $this->authorize('update',$classes);

        $auth_user = Auth::user();
        
            return view('pages.classes.edit',[
                'data'=> User::with([$auth_user->role->name,'role'])->where('id',Auth::id())->get()[0],
                'the_class' => $classes,
                'class_types' => ClassType::all(),
                
                ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classes $classes)
    {
        $this->authorize('update', $classes);
        $request->validate([
            'name' => 'required',
            'class_category' => 'required',
        ]);
        $classes->name = $request->input('name');
        $classes->class_type_id = $request->input('class_category');
        $classes->save();
        return redirect('/classes')->with('class-updated-success', 'Class Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $classes)
    {
        $this->authorize('delete', $classes);
        
        $class_name = $classes->name;
        $classes->delete();
        return back()->with('class-deleted-success', $class_name.' has been deleted successful.');
    }
}
