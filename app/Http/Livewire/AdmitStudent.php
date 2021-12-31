<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\State;
use App\Models\Lga;
use App\Models\Session;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentSectionSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdmitStudent extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $state;
    public $lgas;
    public $section_class;
    public $sections;
    public $session_id;
    public $year_admitted, $email;
    //public $password, $password_confirmation;
    public $name; 
    public $dob; 
    public $admin_no;
    public $phone1, $phone2, $gender, $lga, $address;
    public $section_id;
    public $current_session_year;

    protected $rules = [
        'year_admitted' => 'digits:4',
        'email' => 'required|email:filter|unique:users,email',
        //'password' => 'required|min:6|confirmed',
        'name' => 'required|max:250',
        'dob' => 'required',
        'gender' => 'required|max:6',
        'address' => 'nullable|max:250',
        'phone1' => 'nullable|max:20',
        'phone2' => 'nullable|max:20',
        'lga' => 'required_with:state',
        'section_id' => 'required',
        'session_id' => 'required',
    ];

    public function mount(){
        //$current_session_year = Setting::where('key','current.session')->get()->first()['value'];
        $this->session_id = Setting::where('key','current.session')->get()->first()['value'];
        $session = Session::find($this->session_id);
        $this->current_session_year = $session->start;
        $this->year_admitted = $session->start;

    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function setLga(){
        $this->lgas = Lga::where('state_id',$this->state)->get();
        
    }

    public function setSections(){
        $sections = Section::where('classes_id',$this->section_class)->get();
        
        $this->sections = $sections;
        
     }

     public function saveStudent(){
        $this->validate();
        
        try{

             DB::transaction( function()  {
                     //retrieve student role
             $role = Role::where('name','student')->first();
             
             //create new user record
             $user = new User([
                 'name' => $this->name,
                 'email' => $this->email,
                 'password' => Hash::make('password'),
                 'role_id' => $role->id
             ]);
             $user->save();
             $user->student()->save(new Student([
                 'year_admitted' => $this->year_admitted==''?$this->current_session_year:$this->year_admitted,
                 'dob' => $this->dob,
                 'phone1' => $this->phone1==''?'Nil':$this->phone1,
                 'phone2' => $this->phone2==''?'Nil':$this->phone1,
                 'address' => $this->address==''?'Nil':$this->address,
                 'gender' => $this->gender,
                 'state_id' => $this->state==''?15:$this->state, //set FCT if empty
                 'lga_id' => $this->lga==''?281:$this->state,  // set Municipal Area Council if empty

             ]));

             $student_section_session = StudentSectionSession::create([
                    'student_id' => $user->student->id,
                    'section_id' => $this->section_id,
                    'session_id' => $this->session_id,
             ]);
 
             
             
             },3);
 
         }catch(Exception $e){
             return session()->flash('student-added-fail',"Something Went Wrong");
         }
         
         session()->flash('student-added-success',"Student Admitted Successfully. "."email: ".$this->email);
     }

    public function render()
    {
        return view('livewire.admit-student',[
            'states' => State::all(),
            'sessions' => Session::all(),
            'all_classes' => Classes::all(),
        ]);
    }
}
