<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Section;
use App\Models\Classes;

class ClassSection extends Component
{

    
    public $section_class;
    public $sections;

    
    
    public function setSections(){
        $sections = Section::where('classes_id',$this->section_class)->get();
        
        $this->sections = $sections;
        
     }

    public function render()
    {
        return view('livewire.class-section',['all_classes' => Classes::all(),]);
    }
}
