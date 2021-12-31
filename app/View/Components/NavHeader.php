<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Models\User;

class NavHeader extends Component
{
    public $notices;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->notices = User::find(Auth::id())->role->notices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-header');
    }
}
