<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Section;
use App\Models\Classes;
use App\Models\Subject;
use App\Support\Helpers\SchoolSetting;
use App\Models\StudentSectionSession;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentExamRegistration extends Component
{
    public $section_class;
    public $section_id;
    public $sections;
    private $students;
    private $subjects;
    public $selected_subjects;
    public $selected_student ;
    public $registered_subjects;
    public $modal_initialized = false;
   

    public function setSections(){
        $this->sections = Section::where('classes_id',$this->section_class)->get();
    }

    public function registerSubjects(){
        $success = DB::transaction(function() {
            
        },3);
    } 

    public function syncSubjects($subject_id){
        //check if subject is registered
        $mark = Mark::where([
                    'exam_id'=> SchoolSetting::getSchoolSetting('active.exam'),
                    'student_id' => $this->selected_student->id,
                    'section_id' => $this->section_id,
                    'subject_id' => $subject_id
                    ])->first();
        if($mark){
            
            $mark->destroy($mark->id);
            //$this->initRegistrationModal($this->selected_student->id);
            return;
        }
        $mark = new Mark();
        $mark->exam_id = SchoolSetting::getSchoolSetting('active.exam');
        $mark->student_id = $this->selected_student->id;
        $mark->section_id = $this->section_id;
        $mark->subject_id = $subject_id;
        $mark->save();
        //$this->initRegistrationModal($this->selected_student->id);
    }
    public function loadStudents(){
        $section_id = $this->section_id;
        $session_id = SchoolSetting::getSchoolSetting('current.session');
        $students = StudentSectionSession::where('section_id',$section_id)
                                ->where('session_id',$session_id)
                                ->join('students','students_sections_sessions.student_id','=','students.id')
                                ->join('users','students.user_id','=','users.id')
                                ->get();
         $this->students = $students->where('deleted_at',null); 
    }

    public function sessionSectionStudents($section_id,$session_id = null){
        if($session_id==null){
            $session_id = SchoolSetting::getSchoolSetting('current.session');
        }

        $students = StudentSectionSession::where('section_id',$section_id)
                                ->where('session_id',$session_id)
                                ->join('students','students_sections_sessions.student_id','=','students.id')
                                ->join('users','students.user_id','=','users.id')
                                ->get();
         return $students->where('deleted_at',null); 
    }
    
    public function initRegistrationModal($student_id){
        
        $this->selected_student = Student::find($student_id);
        
        $registered_subjects = Mark::where([
                                    'exam_id' => SchoolSetting::getSchoolSetting('active.exam'),
                                    'section_id' =>$this->section_id,
                                    'student_id' => $student_id
                                ])->get();
        
        $this->registered_subjects = $registered_subjects;
        $this->modal_initialized = true;

        $this->dispatchBrowserEvent('show-registration-modal');
    }
    public function render()
    {
        $students = $this->students;
        $sections = $this->sections;
        return view('livewire.student-exam-registration',[
            'sections' => $sections,
            'all_classes' => Classes::all(),
            'students' => $students,
            'subjects' => Subject::all(),
            'exam' => Exam::find(SchoolSetting::getSchoolSetting('active.exam')),
            
        ]);
    }
}
