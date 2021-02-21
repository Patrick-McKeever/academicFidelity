<?php

namespace App\Http\Controllers\resources;

use App\Models\test;
use App\Models\spreadsheet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    //Make new test for given spreadsheet.
    public function store(Request $postReq)
    {
        //Find spreadsheet to which user is trying to add test.
        $sheetId = $postReq->input('spreadsheetId');
        $spreadsheet = spreadsheet::find($sheetId);

        //Does user own spreadsheet? (Can't be done with authorize, since we'd need to pass a sheet rather than test.)
        if($spreadsheet->ownerId == Auth::user()->id) {
            test::create([
                'name' => $postReq->input('name'),
                'date' => $postReq->input('date'),
                'spreadsheetId' => $postReq->input('spreadsheetId'),
            ]);
        } else {
            return response('Not authorized', 401);
        }
    }

    //Return test as JSON.
    public function show(test $test)
    {
        $test = test::with('spreadsheetValue')->get()->
            where('id', $test['id'])->first();
        $this->authorize('view', $test);
        return response()->json($test);
    }

    //Update test.
    public function update(Request $putReq, test $test)
    {
        $this->authorize('update', $test);
        $test->name = $putReq->input('name');
        $test->date = $putReq->input('date');
        $test->save();
    }

    //Delete test.
    public function destroy(test $test)
    {
        $this->authorize('delete', $test);
        $test->delete();
    }
}
