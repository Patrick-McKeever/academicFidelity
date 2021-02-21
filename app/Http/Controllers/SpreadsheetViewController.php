<?php

namespace App\Http\Controllers;

use App\Models\spreadsheet;
use Illuminate\Http\Request;

class SpreadsheetViewController extends Controller
{
    public function show(int $spreadsheetId)
    {
        $spreadsheet = spreadsheet::find($spreadsheetId);
        $classSheets = $spreadsheet->class->spreadsheets;

        $this->authorize('view', $spreadsheet);
        return View('spreadsheetView')
                ->with('spreadsheet', $spreadsheet)
                ->with('classSheets', $classSheets);
    }
}
