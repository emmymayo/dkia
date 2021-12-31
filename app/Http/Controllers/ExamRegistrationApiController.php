<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Mark;
use App\Models\Exam;
use App\Support\Helpers\SchoolSetting;

class ExamRegistrationApiController extends Controller
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

    public function subjectIndex(){

        return response()->json(Subject::all(), 200);
    }

    public function studentRegisteredSubjects($student_id, $section_id){
        
        $registered_subjects = Mark::where([
            'exam_id' => SchoolSetting::getSchoolSetting('active.exam'),
            'section_id' => $section_id,
            'student_id' => $student_id
        ])->get();
        //$registered_subjects = $registered_subjects->only(['subject_id']);
        return response()->json($registered_subjects, 200);
    }

    public function activeExam(){
        return response()->json(Exam::find(SchoolSetting::getSchoolSetting('active.exam')),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
