<?php

namespace App\Http\Controllers\resources;

use App\Models\classMember;
use App\Models\spreadsheet;
use App\Models\test;
use App\Http\Controllers\Controller;
use App\Models\userOwnedClass;
use Illuminate\Http\Request;

class ClassMemberController extends Controller
{
    //How is student doing on tests?
    public function performance($id) {
        $student = classMember::find($id);
        $this->authorize('view', $student);

        $studentValues = $student->spreadsheetValues;

        $values = [];

        foreach($studentValues as $studentValue) {
            $spreadsheet = $studentValue->spreadsheet;

            if($studentValue->value !== null) {
                if(! isset($values[$spreadsheet['id']])) {
                    $values[$spreadsheet['id']]['standards'] = $spreadsheet['standards'];
                    $values[$spreadsheet['id']]['name'] = $spreadsheet['name'];
                    $values[$spreadsheet['id']]['scores'] = [];
                }

                $test = test::find($studentValue->testId);
                $values[$spreadsheet['id']]['scores'][$test['date']] = $studentValue->value;
            }
        }

        return response()->json($values);
    }

    public function store(Request $postReq)
    {
        //Does user own the class to which they are attempting to add a member?
        $class = userOwnedClass::find($postReq->input('classId'));
        $this->authorize('create', $class);

        $studNames = $postReq->input('students');
        $emails = $postReq->input('emails');

        //Note that, on the front end, the arrays are padded to have the same length.
        for($i = 0; $i < count($studNames); $i++) {
            classMember::create([
                'name' => $studNames[$i],
                'email' => $emails[$i],
                'classId' => $postReq->input('classId')
            ]);
        }
    }

    //Return json for specific classmember.
    public function show(classMember $classMember)
    {
        $this->authorize('view', $classMember);
        return response()->json($classMember);
    }

    //Update student object.
    public function update(Request $putReq, classMember $classMember)
    {
        $this->authorize('update', $classMember);
        $classMember->name = $putReq->input('name');
        $classMember->email = $putReq->input('email');
        $classMember->save();
    }

    //Delete student object.
    public function destroy(classMember $classMember)
    {
        $this->authorize('delete', $classMember);
        $classMember->delete();
    }
}
