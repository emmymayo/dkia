<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Session;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Exam::class);

        return view('pages.exams.index',[
            'exams' => Exam::all(),
            'sessions' => Session::all(),
        ]);
    }

    public function getExams()
    {
        $exams = Exam::all();
        return response()->json($exams,200);
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
        $this->authorize('create', Exam::class);

        $request->validate([
            'name' => 'required|max:200|unique:exams,name',
            'term' => 'required',
            'session' => 'required'
        ]);

        $exam = new Exam;
        $exam->name = $request->input('name');
        $exam->term = $request->input('term');
        $exam->session_id = $request->input('session');
        if ($exam->save()){
            return back()->with('action-success','Exam has been successfully created');
        } 
        return back()->with('action-fail','Something went wrong. Try Again');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);

        return view('pages.exams.edit',[
            'exam' => $exam,
            'sessions' => Session::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $this->authorize('update', $exam);
        $request->validate([
            'name' => 'required|max:200',
            'term' => 'required',
            'session' => 'required'
        ]);

        $exam->name = $request->input('name');
        $exam->term = $request->input('term');
        $exam->session_id = $request->input('session');
        if ($exam->save()){
            return redirect('/exams')->with('action-success','Exam has been successfully edited');
        } 
        return back()->with('action-fail','Something went wrong. Try Again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);
        if ($exam->delete()){
            return back()->with('action-success','Exam Deleted Successfully');
        } 
        return back()->with('action-fail','Something went wrong. Try Again');
    }

    public function publish(Exam $exam){

        $this->authorize('update', $exam);
        $exam->published == 1? $exam->published = 0
                             : $exam->published = 1;
        if ($exam->save()){
            return back()->with('action-success','Exam Status has been changed');
        } 
        return back()->with('action-fail','Something went wrong. Try Again');

    }
  
}
