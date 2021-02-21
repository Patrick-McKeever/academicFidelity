<?php

namespace App\Http\Controllers\resources;

use App\Models\groupMember;
use Illuminate\Http\Request;
use App\Models\group;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GroupMemberController extends Controller
{
    //Request contains a "join code" which should theoretically respond to a given group.
    //If the join code does correspond, we'll add the user as a groupMember.
    public function store(Request $postReq)
    {
        $joinCode = $postReq->input('joinCode');
        //Join code is unique.
        $group = group::where('joinCode', $joinCode)->get()->first();
        $membershipParams = [
            'groupId' => $group->id,
            'userId' => Auth::user()->id
        ];

        if($group->exists()) {
            //Throw error if user has already joined group.
            if(groupMember::where($membershipParams)->exists()) {
                return response('Group already joined.', 409);
            } else {
                groupMember::create($membershipParams);
            }
        } else {
            //Join code has no corresponding group.
            return response('Join Code does not correspond to any group.', 404);
        }
    }

    //Remove the user as a member of the given group.
    public function destroy($groupId)
    {
        $groupMember = groupMember::where([
            'userId' => Auth::user()->id,
            'groupId' => $groupId
        ])->get()->first();

        $this->authorize('delete', $groupMember);

        //Gotta use builder for this, can't use $groupMember.
        groupMember::where([
            'userId' => Auth::user()->id,
            'groupId' => $groupId
        ])->delete();
    }
}
