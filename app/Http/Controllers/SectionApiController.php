<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\TeacherSection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SectionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
 /**
     * Display a listing of the resource by class.
     *
     * @return \Illuminate\Http\Response
     */
    public function classSections($classes_id)
    {
        return response()->json(Section::where('classes_id',$classes_id)
                            ->get(),200);
    }

    public function mySections($classes_id)
    {
        $user = User::find(Auth::id());
        $sections = null;
        if($user->isAdmin()){
            $sections = Section::where('classes_id',$classes_id)
                                ->get();
        }
        else if($user->isTeacher()){
            $teacher_id = $user->teacher->id;
            $sections = Section::whereIn('id', function($query) use($teacher_id,$classes_id){
                        $query->select('section_id')
                        ->from('teacher_sections')
                        ->where('teacher_id',$teacher_id)
                        ->get();
                    })->where('classes_id',$classes_id)
                    ->get();
        }
        
        return response()->json($sections,200);
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
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return response()->json($section);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}
