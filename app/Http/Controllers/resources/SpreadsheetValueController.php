<?php

namespace App\Http\Controllers\resources;

use App\Models\spreadsheetValue;
use App\Models\spreadsheet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpreadsheetValueController extends Controller
{
    //Takes spreadsheet data stored as multidimensional array of json[row][column], stores values in db.
    public function store(Request $postReq)
    {
        $sheetId = $postReq->input('sheetId');
        $rawData = $postReq->input('data');

        $spreadsheet = spreadsheet::find($sheetId);

        //Since we're dealing with an arr of SS values, we can't use policy here.
        //Easier to just check manually.
        if($spreadsheet->ownerId == Auth::user()->id) {
            $sheetTests = $spreadsheet->tests;
            $students = $spreadsheet->class->students;

            foreach ($students as $sIndex => $student) {
                foreach ($sheetTests as $tIndex => $test) {
                    //Do we use update or insert?
                    $ssValBuilder = spreadsheetValue::where('testId', $test['id'])
                        ->where('studentId', $student['id'])
                        ->where('spreadsheetId', $sheetId);

                    if ($ssValBuilder->exists()) {
                        $ssVal = $ssValBuilder->get()->first();
                        $ssVal->value = $rawData[$sIndex][$tIndex];
                        $ssVal->save();
                    } else {
                        spreadsheetValue::create([
                            'testId' => $test['id'],
                            'studentId' => $student['id'],
                            'spreadsheetId' => $sheetId,
                            'value' => $rawData[$sIndex][$tIndex]
                        ]);
                    }
                }
            }
        } else {
            return response('Not authorized', 401);
        }
    }

    //Get all spreadsheet values from DB structure, return.
    public function show($spreadsheetId)
    {
        $values = spreadsheetValue::where('spreadsheetId', $spreadsheetId)->get();
        return Response()->json($values);
    }
}
