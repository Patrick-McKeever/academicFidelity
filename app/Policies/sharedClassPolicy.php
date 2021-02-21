<?php

namespace App\Policies;

use App\Models\User;
use App\Models\sharedClass;
use App\Models\userOwnedClass;
use App\Models\group;
use Illuminate\Auth\Access\HandlesAuthorization;

class sharedClassPolicy
{
    use HandlesAuthorization;

    //To share a class with the group, the user must own the class and be a group member.
    public function create(User $user, userOwnedClass $class, group $group)
    {
        $ownsClass = ($class->owner == $user);

        $isMember = false;
        foreach($user->memberships as $membership) {
            if($membershipGroup == $group) {
                $isMember = true;
                break;
            }
        }

        return $ownsClass && $isMember;
    }

    //Users can remove classes from a group if they own the group or the class.
    public function delete(User $user, sharedClass $sharedClass)
    {
        $ownsGroup = ($sharedClass->group->owner == $user);
        $ownsClass = ($sharedClass->class->owner == $user);
        return $ownsGroup || $ownsClass;
    }
}
