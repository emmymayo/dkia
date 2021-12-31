<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\State;
use App\Models\Lga;

class StateLga extends Component
{
    public $state_id;
    public $lgas;

    
    public function setLga(){
        $this->lgas = Lga::where('state_id',$this->state_id)->get();
        
    }

    public function render()
    {
        return view('livewire.state-lga', ['states' => State::all(),]);
    }
}
