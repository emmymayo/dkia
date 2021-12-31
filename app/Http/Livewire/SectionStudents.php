<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Classes;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use App\Support\Helpers\SchoolSetting;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class SectionStudents extends Component
{
    use AuthorizesRequests;

    public $section_class ;
    public $sections ;
    public $section_id ;
    private $students ;
    private $notification ;
    
  

    public function setSections(){
       $sections = Section::where('classes_id',$this->section_class)->get();
       
       $this->sections = $sections;
       
    }

    public function loadStudents(){
        
        $session_id = SchoolSetting::getSchoolSetting('current.session');
        $students = DB::table('students_sections_sessions')
                                    ->select('students_sections_sessions.*','students.*','users.name','users.avatar','users.status')
                                    ->where(['section_id' => $this->section_id, 'session_id' => $session_id])
                                    ->join('students','students_sections_sessions.student_id','=','students.id')
                                    ->join('users','students.user_id','=','users.id')
                                    ->get();
        $this->students = $students->where('deleted_at',null); 
      
       
    }

    public function resetStudentPassword(User $user){
        $this->authorize('update',Student::class);
        $user->password = Hash::make("password");
        $user->save();
        
        session()->flash('password-reset-success','Password Reset Successful');
        $this->loadStudents();
    }

    public function toggleStudentStatus(User $user){
        $this->authorize('update',Student::class);
        $user->status = $user->status===0?1:0;
        $user->save();
        session()->flash('toggle-status-success','Status Changed Successfully');
        $this->loadStudents();
    }
    
    public function deleteStudent(Student $student){
        $this->authorize('delete',Student::class);
        $name = $student->user->name;
        try{
            DB::transaction(function() use($student){
                $student->user->status = 0;
                $student->save();
                $student->user->delete();
                $student->delete();
            });
        }catch(Exception $e){
             session()->flash('student-delete-fail', 'Something went wrong. Try Again');
             $this->loadStudents();
        }
       
         session()->flash('student-delete-success', $name.' Has Been Removed Successfully');
         $this->loadStudents();
    }

    
    
    public function render()
    {
        return view('livewire.section-students',['all_classes'=> Classes::all(),
                                        'students'=> $this->students,
                                        'notification' =>$this->notification,]);
    }
}
