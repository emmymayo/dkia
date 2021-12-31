<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EClass;
use App\Models\Student;
use App\Support\Helpers\Exam;

class StudentEClassesController extends Controller
{
    public function index(){
        $student = Student::firstWhere('user_id',auth()->id());
        $student_section = Exam::getStudentCurrentSection($student->id);
        $eclasses = EClass::query()
                            ->where('section_id',$student_section->id)
                            ->latest()
                            ->paginate(15);
            
        return view('pages.eclasses.student-index',[
            'eclasses' => $eclasses
        ]);
    }
}
