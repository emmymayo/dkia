<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Section::class);

        $auth_user = Auth::user();
        
        return view('pages.sections.index',[
            'data'=> User::with([$auth_user->role->name,'role'])->where('id',Auth::id())->get()[0],
            'sections' => Section::all(),
            'classes' => Classes::all(),
            
            ]);

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
        $this->authorize('create', Section::class);

        $request->validate([
            'name'=>'required|max:50',
            'section_class' => 'required',
        ]);

        $classes = new Section([
            'name' => $request->input('name'),
            'classes_id' => $request->input('section_class'),
        ]);
        $classes->save();

        return back()->with('section-added-success',$request->input('name').' has been successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        $this->authorize('update',$section);

        $auth_user = Auth::user();
        
            return view('pages.sections.edit',[
                'data'=> User::with([$auth_user->role->name,'role'])->where('id',Auth::id())->get()[0],
                'section' => $section,
                'classes' => Classes::all(),
                
                ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $this->authorize('update', $section);
        $request->validate([
            'name' => 'required',
            'section_class' => 'required',
        ]);
        $section->name = $request->input('name');
        $section->classes_id = $request->input('section_class');
        $section->save();
        return redirect('/sections')->with('section-updated-success', 'Section Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $this->authorize('delete', $section);
        
        $section_name = $section->name;
        $section->delete();
        return back()->with('section-deleted-success', $section_name.' has been deleted successful.');
    }
}
