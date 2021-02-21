<?php

namespace App\Policies;

use App\Models\User;
use App\Models\spreadsheet;
use App\Modles\userOwnedClass;
use Illuminate\Auth\Access\HandlesAuthorization;

class spreadsheetPolicy
{
    use HandlesAuthorization;

    //Did user create spreadsheet or has spreadsheet owner shared the sheet with a group?
    public function view(User $user, spreadsheet $spreadsheet)
    {
        $sheetClass = $spreadsheet->class;
        $ownsSheet = ($sheetClass->owner == $user);
        $partOfGroup = $sheetClass->canViewClass($user);

        return $ownsSheet || $partOfGroup;
    }

    //User must own a class before adding spreadsheets to it.
    public function create(User $user, userOwnedClass $class)
    {
        return ($class->owner == $user);
    }

    public function update(User $user, spreadsheet $spreadsheet)
    {
        return ($spreadsheet->class->owner == $user);
    }

    public function delete(User $user, spreadsheet $spreadsheet)
    {
        return ($spreadsheet->class->owner == $user);
    }
}
