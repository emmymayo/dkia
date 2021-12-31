<?php

namespace App\Http\Controllers;

use App\Models\StudentSectionSession;
use Illuminate\Http\Request;

class StudentSectionSessionController extends Controller
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
     * @param  \App\Models\StudentSectionSession  $studentSectionSession
     * @return \Illuminate\Http\Response
     */
    public function show(StudentSectionSession $studentSectionSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentSectionSession  $studentSectionSession
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentSectionSession $studentSectionSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentSectionSession  $studentSectionSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentSectionSession $studentSectionSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentSectionSession  $studentSectionSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentSectionSession $studentSectionSession, Request $request)
    {
        //Prevent deletion of only class
        $section_count = StudentSectionSession::where('student_id',$request->input('student_id'))->count();
        if($section_count<=1){
            return back();
        }
        StudentSectionSession::find($request->input('id'))->delete();
        return back();
    }
}
