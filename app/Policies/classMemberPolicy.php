<?php

namespace App\Policies;

use App\Models\User;
use App\Models\classMember;
use App\Models\userOwnedClass;
use Illuminate\Auth\Access\HandlesAuthorization;

class classMemberPolicy
{
    use HandlesAuthorization;

    //Does classMember reference the current user or did current user create classMember?
    public function view(User $user, classMember $classMember)
    {
        $classMemberIsUser = ($classMember->email == $user->email);
        $userCreatedClassMember = ($classMember->class->owner == $user);

        return $classMemberIsUser || $userCreatedClassMember;
    }

    //If user wants to add a member to a class, they need to own said class.
    public function create(User $user, userOwnedClass $class)
    {
        return ($class->owner == $user);
    }

    public function update(User $user, classMember $classMember)
    {
        return ($classMember->class->owner == $user);
    }

    public function delete(User $user, classMember $classMember)
    {
        return ($classMember->class->owner == $user);
    }
}
