<?php

namespace App\Http\Controllers\resources;

use App\Models\spreadsheet;
use App\Models\userOwnedClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpreadsheetController extends Controller
{
    public function store(Request $postReq)
    {
        $class = userOwnedClass::find($postReq->input('classId'));
        $this->authorize('create', $class);

        spreadsheet::create([
            'classId' => $postReq->input('classId'),
            'name' => $postReq->input('name'),
            //'standards' and 'slgs' are stringified json arrs.
            'standards' => '[]',
            'slgs' => '{}',
            'ownerId' => Auth::user()->id
        ]);
    }

    //Return JSON for given spreadsheet.
    public function show(spreadsheet $spreadsheet)
    {
        $this->authorize('view', $spreadsheet);
        $spreadsheet = $spreadsheet::with('class', 'tests', 'spreadsheetVals')
            ->where('id', $spreadsheet->id)->first();
        return response()->json($spreadsheet);
    }

    //Updates spreadsheet name.
    public function update(Request $putReq, spreadsheet $spreadsheet)
    {
        $this->authorize('update', $spreadsheet);
        $spreadsheet->name = $putReq->input('name');
        $spreadsheet->standards = $putReq->input('standards');
        $spreadsheet->slgs = $putReq->input('slgs');
        $spreadsheet->save();
    }

    //Destroy spreadsheet.
    public function destroy(spreadsheet $spreadsheet)
    {
        $this->authorize('delete', $spreadsheet);
        $spreadsheet->delete();
    }
}
