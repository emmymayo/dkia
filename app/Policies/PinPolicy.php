<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PinPolicy
{
    use HandlesAuthorization;

    
    public function before(User $user, $ability)
    {
        if($user->role->name == 'admin' OR $user->role->name == 'sa'){return true;}
        return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

}
