<?php

namespace App\Http\Controllers\resources;

use App\Models\teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    //List teachers with boolean value of 'archived' given by user.
    public function index($archived)
    {
        $teachers = teacher::where([
            'archived' => $archived,
            'creatorId' => Auth::user()->id
        ])->get();

        return response()->json($teachers);
    }

    //Return JSON corresponding to teacher.
    public function show(teacher $teacher)
    {
        $this->authorize('view', $teacher);
        //Simplest way to get controller to return the "evaluations attribute.
        $teacher->evaluations;

        return response()->json($teacher);
    }

    //Create teacher based on post req from user.
    public function store(Request $postReq)
    {
        teacher::create([
            'name' => $postReq->input('name'),
            'email' => $postReq->input('email'),
            'school' => $postReq->input('school'),
            'creatorId' => Auth::user()->id
        ]);
    }

    //Update teacher values.
    public function update(Request $putReq, teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $teacher->name = $putReq->input('name');
        $teacher->email = $putReq->input('email');
        $teacher->school = $putReq->input('school');
        $teacher->archived = $putReq->input('archived');

        $teacher->save();
    }
}
