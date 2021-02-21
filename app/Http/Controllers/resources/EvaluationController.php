<?php

namespace App\Http\Controllers\resources;

use App\Models\evaluation;
use App\Models\teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    //Show evaluations of user that are either observations or pre-observations, depending on bool input.
    public function index($preObs)
    {
        //Teach objects with same email as user.
        $teachers = teacher::where('email', Auth::user()->email)->get();
        $evals = [];

        foreach($teachers as $teacher) {
            foreach($teacher->evaluations as $evaluation) {
                if($evaluation['preObs'] == $preObs) {
                    array_push($evals, $evaluation);
                }
            }
        }

        return response()->json($evals);
    }

    //Create new evaluation.
    public function store(Request $postReq)
    {
        $teacher = teacher::find($postReq->input('teacherId'));
        if($teacher->creatorId == Auth::user()->id) {
            evaluation::create([
                'date' => $postReq->input('date'),
                'creatorId' => Auth::user()->id,
                'teacherId' => $postReq->input('teacherId'),
                //Whether observation should be classed as a "pre observation" form.
                'preObs' => $postReq->input('preObs') == 'true',
                //'evaluation' is a stringified JSON object.
                'evaluation' => '{}'
            ]);
        } else {
            return response('Not authorized', 403);
        }
    }

    //Show specific evaluation.
    public function show(evaluation $evaluation)
    {
        $this->authorize('view', $evaluation);

        //Load teacher property.
        $evaluation->teacher;

        return response()->json($evaluation);
    }

    //Update evaluation.
    // Note that this is used to change the content of the observation, which is stored as stringified JSON.
    public function update(Request $putReq, evaluation $evaluation)
    {
        $this->authorize('update', $evaluation);

        $evaluation->date = $putReq->input('date');
        $evaluation->evaluation = $putReq->input('evaluation');

        $evaluation->save();
    }

    public function destroy(evaluation $evaluation)
    {
        //
    }
}
