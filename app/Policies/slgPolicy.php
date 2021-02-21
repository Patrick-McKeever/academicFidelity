<?php

namespace App\Policies;

use App\Models\User;
use App\Models\slg;
use App\Models\spreadsheet;
use Illuminate\Auth\Access\HandlesAuthorization;

class slgPolicy
{
    use HandlesAuthorization;

    //User owns spreadsheet or user is part of group that can view class.
    public function view(User $user, slg $slg)
    {
        $sheetClass = $slg->spreadsheet->class;
        $ownsSheet = ($sheetClass->owner == $user);
        $partOfGroup = canViewClass($user, $sheetClass);

        return $ownsSheet || $partOfGroup;
    }

    //User must own a spreadsheet to add SLGs to it.
    public function create(User $user, spreadsheet $spreadsheet)
    {
        return ($spreadsheet->class->owner == $user);
    }

    public function update(User $user, slg $slg)
    {
        $sheetClass = $slg->spreadsheet->class;
        return ($sheetClass->owner == $user);
    }

    public function delete(User $user, slg $slg)
    {
        $sheetClass = $slg->spreadsheet->class;
        return ($sheetClass->owner == $user);
    }
}
