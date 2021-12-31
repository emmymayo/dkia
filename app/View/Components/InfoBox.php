<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;

class InfoBox extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $admins = 0; 
    public $teachers = 0;
    public $students = 0;
    public function __construct($admins=null,$teachers=null,$students=null)
    {
        if(is_null($admins)){$this->admins= Admin::count();}
        if(is_null($teachers)){$this->teachers= Teacher::count();}
        if(is_null($students)){$this->students= Student::count();}
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.info-box');
    }
}
