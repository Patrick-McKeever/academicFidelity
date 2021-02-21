<?php

namespace App\Policies;

use App\Models\User;
use App\Models\evaluation;
use Illuminate\Auth\Access\HandlesAuthorization;

class evaluationPolicy
{
    use HandlesAuthorization;

    //Is the evaluation evaluating the user or did the user create the evaluation?
    public function view(User $user, evaluation $evaluation)
    {
        $userIsTeacher = ($evaluation->teacher->email == $user->email);
        $userCreatedEval = ($evaluation->creator == $user);
        return $userIsTeacher || $userCreatedEval;
    }

    //Students have no need to make evaluations.
    public function create(User $user)
    {
        return ($user->userType == 'teacher');
    }

    public function update(User $user, evaluation $evaluation)
    {
        return ($evaluation->creator == $user);
    }

    public function delete(User $user, evaluation $evaluation)
    {
        return ($evaluation->creator == $user);
    }
}
