<?php

namespace App\Http\Controllers\resources;

use Illuminate\Http\Request;
use App\Models\sharedClass;
use App\Models\group;
use App\Models\groupMember;
use App\Models\userOwnedClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SharedClassController extends Controller
{
    //Show classes shared with given group.
    public function show($groupId) {
        //Is user a group member?
        $authorized = groupMember::where([
            'groupId' => $groupId,
            'userId' => Auth::user()->id
        ])->exists();

        if($authorized) {
            $sharedClasses = [];

            //Note that the iterable is an abstraction of a class of form {groupId: {id}, classId: {id}}.
            foreach(group::find($groupId)->classes as $classShare) {
                array_push($sharedClasses, $classShare->class);
            }

            return response()->json($sharedClasses);
        } else {
            return response('Not authorized', 403);
        }
    }

    //Share a class with a group.
    public function store(Request $postReq) {
        $classId = $postReq->input('classId');
        $groupId = intval($postReq->input('groupId'));
        $class = userOwnedClass::find($classId);

        if(Auth::user()->id == $class->ownerId) {
            sharedClass::create([
                'classId' => $classId,
                'groupId' => $groupId
            ]);
        } else {
            return response('Not authorized', 403);
        }
    }

    //Unshare class with group.
    public function destroy(sharedClass $sharedClass) {
        $this->authorize('delete', $sharedClass);
        $sharedClass->delete();
    }
}
