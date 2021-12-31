<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Support\Helpers\SchoolSetting;

class ExamReportEntryApiController extends Controller
{

    public function sectionSubjectEntries($section_id, $subject_id){

        
        $mark = Mark::where([
                    'exam_id' => SchoolSetting::getSchoolSetting('active.exam'),
                    'section_id' => $section_id,
                    'subject_id' => $subject_id,
                    ])->get();
        $assessments = config('settings.cass');
        return response()->json(['data' => $mark,
                                'assessments' => $assessments],200);

    }

    public function subjectIndex(){
        return response()->json(Subject::all(),200);
    }
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
