<?php

namespace App\Policies;

use App\Models\User;
use App\Models\groupMember;
use App\Models\group;
use Illuminate\Auth\Access\HandlesAuthorization;

class groupMemberPolicy
{
    use HandlesAuthorization;

    //If user is the groupMember or user is groupOwner, they can get rid of the membership.
    //I.e. you can cancel your own membership and you can cancel others' memberships if you own the group.
    public function delete(User $user, groupMember $groupMember)
    {
        $memberIsUser = ($groupMember->user == $user);
        $userOwnsGroup = ($groupMember->group->owner == $user);
        return $memberIsUser || $userOwnsGroup;
    }

}
