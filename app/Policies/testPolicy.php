<?php

namespace App\Policies;

use App\Models\User;
use App\Models\test;
use App\Models\spreadsheet;
use Illuminate\Auth\Access\HandlesAuthorization;

class testPolicy
{
    use HandlesAuthorization;

    //Is user part of group that can view spreadsheet's class or did user make spreadsheet?
    public function view(User $user, test $test)
    {
        $testClass = $test->spreadsheet->class;
        $ownsSheet = ($testClass->owner == $user);
        $priveleged = $testClass->canViewClass($user);

        return $ownsSheet || $priveleged;
    }

    //You need to own a spreadsheet to add tests to it.
    public function create(User $user, spreadsheet $spreadsheet)
    {
        return ($spreadsheet->class->owner == $user);
    }

    public function update(User $user, test $test)
    {
        $testClass = $test->spreadsheet->class;
        return ($testClass->owner == $user);
    }

    public function delete(User $user, test $test)
    {
        $testClass = $test->spreadsheet->class;
        return ($testClass->owner == $user);
    }
}
