<?php

namespace App\Policies;

use App\Models\User;
use App\Models\userOwnedClass;
use Illuminate\Auth\Access\HandlesAuthorization;

class userOwnedClassPolicy
{
    use HandlesAuthorization;

    // Did user create class or is user part of group with perms to view class?
    public function view(User $user, userOwnedClass $class)
    {
        $isOwner = ($class->owner == $user);
        $priveleged = $class->canViewClass($user);

        return $isOwner || $priveleged;
    }

    public function create(User $user)
    {
        return ($user->userType == 'teacher');
    }

    public function update(User $user, userOwnedClass $class)
    {
        return ($user->id == $class->ownerId);
    }

    public function delete(User $user, userOwnedClass $class)
    {
        return ($user->id == $class->ownerId);
    }
}
