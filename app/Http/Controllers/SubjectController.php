<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherSection;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Subject::class);
        return view('pages.subjects.index',[
            'subjects' => Subject::all()
        ]);
    }

    public function getSubjects(){
        $subjects = Subject::all();
        return response()->json($subjects,200);
    }

    public function getExamSectionSubjects($exam_id,$section_id){
        //retrieve subjects students in a section (section_id) registered
        // during an exam (exam_id)
        $subjects = Subject::whereIn('id',
                            function($query) use($exam_id,$section_id){
                                $query->select('subject_id')
                                    ->from('marks')
                                    ->where([
                                        "exam_id"=>$exam_id,
                                        "section_id" => $section_id
                                    ])->get();
                            }    
                    )->get();

        return response()->json($subjects);
    }

    public function mySubjects($section_id){
        $user = User::find(Auth::id());
        $subjects = null;
        if($user->isAdmin()){
            $subjects = Subject::all();
        }
        else if($user->isTeacher()){
            //check if teacher is section teacher then give him all subjects
            //else find teacher subject
            $teacher_id = $user->teacher->id;
            $teacher_section_count = TeacherSection::where('teacher_id',$teacher_id)
                                                ->where('section_id',$section_id)
                                                ->count();
            if($teacher_section_count>0){
                //teacher is section teacher, return all subjects
                $subjects = Subject::all();
            }else{
                //fetch assigned subjects
                $subjects = Subject::whereIn('id', function($query) use($teacher_id,$section_id){
                    $query->select('subject_id')
                    ->from('teacher_section_subjects')
                    ->where('teacher_id',$teacher_id)
                    ->where('section_id',$section_id)
                    ->get();
                })->get();
            }
            
        }
        return response()->json($subjects,200);
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
        $this->authorize('create',Subject::class);
        $request->validate([
            'name' => 'required|max:100',
            'short_name' => 'max:100'
        ]);

        $subject = new Subject();
        $subject->name = $request->input('name');
        $subject->short_name = $request->input('short_name');
        if($subject->save()){
            return back()->with('action-success','Subject added successfully.');
        }
        return back()->with('action-fail','Something went wrong. Try again.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $this->authorize('update',$subject);
        return view('pages.subjects.edit',[
            'subject' => $subject
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $this->authorize('update',$subject);
        $request->validate([
            'name' => 'required|max:100',
            'short_name' => 'max:100'
        ]);

        $subject->name = $request->input('name');
        $subject->short_name = $request->input('short_name');
        if($subject->save()){
            return redirect('/subjects')->with('action-success','Subject updated successfully.');
        }
        return back()->with('action-fail','Something went wrong. Try again.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);
        if($subject->delete()){
            return back()->with('action-success','Subject deleted successfully.');
        }
        return back()->with('action-fail','Something went wrong. Try again.');
    }
}
