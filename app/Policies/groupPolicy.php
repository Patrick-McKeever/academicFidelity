<?php

namespace App\Policies;

use App\Models\User;
use App\Models\group;
use Illuminate\Auth\Access\HandlesAuthorization;

class groupPolicy
{
    use HandlesAuthorization;

    //Users can view groups to which they are members.
    //Bear in mind that group owners are also listed as groupMembers.
    public function view(User $user, group $group)
    {
        foreach($group->members as $member)
        {
            if($member->user == $user)
            {
                return true;
            }
        }
        return false;
    }

    //Students have no need to create groups.
    public function create(User $user)
    {
        return ($user->userType == 'teacher');
    }

    public function update(User $user, group $group)
    {
        return ($group->owner == $user);
    }

    public function delete(User $user, group $group)
    {
        return ($group->owner == $user);
    }
}
