<?php

namespace App\Policies;

use App\Models\User;
use App\Models\teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class teacherPolicy
{
    use HandlesAuthorization;

    //Does teacher object refer to user or did user create teacher object?
    public function view(User $user, teacher $teacher)
    {
        $userIsTeacher = ($teacher->email == $user->email);
        $userCreatedEval = ($teacher->creator == $user);
        return $userIsTeacher || $userCreatedEval;
    }

    public function create(User $user)
    {
        return ($user->userType == 'teacher');
    }

    public function update(User $user, teacher $teacher)
    {
        return ($teacher->creator == $user);
    }

    public function delete(User $user, teacher $teacher)
    {
        return ($teacher->creator == $user);
    }
}
