<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Student;
use App\Models\Setting;
use App\Models\StudentSectionSession;
use App\Models\User;
use App\Support\Helpers\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Student::class);
        $auth_user = Auth::user();
        
        
            return view('pages.students.index',[
                'data'=> User::with([$auth_user->role->name,'role'])->where('id',Auth::id())->get()[0],
                'settings' => Setting::all(),
                
                ]);
    }

    public function getExamSectionStudents($exam_id,$section_id){
        //retrieve subjects students in a section (section_id) registered
        // during an exam (exam_id)
        $students = Student::whereIn('id',
                            function($query) use($exam_id,$section_id){
                                $query->select('student_id')
                                    ->from('marks')
                                    ->where([
                                        "exam_id"=>$exam_id,
                                        "section_id" => $section_id
                                    ])->get();
                            }    
                    )->get();

        return response()->json($students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Student::class);
        return view('pages.students.create',[
            'data'=> User::with(['admin','role'])->where('id',Auth::id())->get()[0],
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $this->authorize('view',$student);

        $student_sections = DB::table('students_sections_sessions')
                        ->select('students_sections_sessions.*','students_sections_sessions.id as sss_id','sections.name','sections.classes_id','sessions.*')
                        ->where(['student_id' => $student->id])
                        ->join('sections','students_sections_sessions.section_id','=','sections.id')
                        ->join('sessions','students_sections_sessions.session_id','=','sessions.id')
                        ->get();
        return view('pages.students.profile',[
            'data'=> User::with(['admin','role'])->where('id',Auth::id())->get()[0],
            'sessions' => Session::all(),
            'profile' => $student,
            'student_sections' => $student_sections,
            'current_session_id'=>SchoolSetting::getSchoolSetting('current.session')
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $this->authorize('update', $student);
        //validate
        $request->validate([
            'name' => 'bail|required|max:250',
            'email' => 'bail|required|email:filter',
            'gender' => 'required|max:6',
            'qualification' => 'max:50',
            'phone1' => 'max:20',
            'phone2' => 'max:20',
            'address' => 'max:250',
             'year_admitted' => 'nullable|digits:4',
             'dob' => 'required',
            
        ]);
        $student->user->name= $request->input('name');
        $student->user->email = $request->input('email');
        $student->gender = $request->input('gender');
        $student->dob = $request->input('dob');
        $student->admin_no = $request->input('admin_no')==null?null:$request->input('admin_no');
        $student->year_admitted = $request->input('year_admitted')==null?null:$request->input('admin_no');
        $student->phone1 = $request->input('phone1')==null?'Nil':$request->input('phone1');
        $student->phone2 = $request->input('phone2')==null?'Nil':$request->input('phone2');
        $student->state_id = $request->input('state_id')==null?$request->input('old_state_id'):$request->input('state_id');
        $student->lga_id = $request->input('lga_id')==null?$request->input('old_lga_id'):$request->input('lga_id');
        $student->address = $request->input('address')==null?'Nil':$request->input('address');
        $saved = DB::transaction(function() use($student){
            $student->user->save();
            return $student->save();
        },3);
        if($saved){
            return back()->with('profile-update-success','Student Profile Updated Successfully');
        }
        return back()->with('profile-update-fail','Something went wrong.');
    }

    public function setClass(Request $request, Student $student)
    {
        $this->authorize('update',$student);
        $request->validate([
            'session_id' => 'required',
            'section_id' => 'required',
        ]);
        //upsert student section data
        $student_section_session = StudentSectionSession::updateOrCreate(
                ['student_id'=> $student->id, 'session_id' => $request->input('session_id') ],
                ['section_id' => $request->input('section_id')]
            );

        return back()->with('profile-update-success','Student Class Set Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
