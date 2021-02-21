<?php

namespace App\Policies;

use App\Models\User;
use App\Models\spreadsheetValue;
use App\Models\spreadsheet;
use Illuminate\Auth\Access\HandlesAuthorization;

class spreadsheetValuePolicy
{
    //Did user create spreadsheet or has spreadsheet owner shared the sheet with a group?
    public function view(User $user, spreadsheetValue $spreadsheetValue)
    {
        $sheetClass = $spreadsheetValue->spreadsheet->class;
        $ownsSheet = ($sheetClass->owner == $user);
        $partOfGroup = canViewClass($user, $sheetClass);

        return $ownsSheet || $partOfGroup;
    }

    //User must own a spreadsheet to add values to it.
    public function create(User $user, spreadsheet $spreadsheet)
    {
        $sheetClass = $spreadsheet->class;
        return ($sheetClass->owner == $user);
    }

    public function update(User $user, spreadsheetValue $spreadsheetValue)
    {
        $sheetClass = $spreadsheetValue->spreadsheet->class;
        return ($sheetClass->owner == $user);
    }

    public function delete(User $user, spreadsheetValue $spreadsheetValue)
    {
        $sheetClass = $spreadsheetValue->spreadsheet->class;
        return ($sheetClass->owner == $user);
    }
}
