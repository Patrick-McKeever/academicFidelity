<?php

namespace App\Http\Controllers\resources;

use Illuminate\Http\Request;
use App\Models\group;
use App\Models\groupMember;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    //List groups to which user is a member with given boolean value for 'archived'.
    public function index(bool $archived)
    {
        $memberships = User::find(Auth::user()->id)->memberships;
        $groups = [];

        foreach($memberships as $membership) {
            if($membership->group->archived == $archived) {
                array_push($groups, $membership->group);
            }
        }

        return response()->json($groups);
    }

    //Stores new group created by user, registers user as member.
    public function store(Request $postReq)
    {
        $this->authorize('create', group::class);

        //Create group.
        $groupId = group::create([
            'name' => $postReq->input('name'),
            'joinCode' => uniqid(),
            'ownerId' => Auth::user()->id,
            'standards' => '[]',
            'slgs' => '{}'
        ])->id;

        //Register user as a member of the group.
        groupMember::create([
            'userId' => Auth::user()->id,
            'groupId' => $groupId
        ]);
    }

    public function show(group $group)
    {
        $this->authorize('view', $group);
        foreach($group->members as $member) {
            //This is clunky, but it's the easiest way to get it to load the user associated with the membership.
            $member->user;
        }
        return response()->json($group);
    }

    //Update existing group.
    public function update(Request $putReq, group $group)
    {
        $this->authorize('update', $group);

        $group->name = $putReq->input('name');

        if($putReq->has('archived')) {
            $group->archived = $putReq->input('archived');
        }

        if($putReq->has('slgs')) {
            $group->slgs = $putReq->input('slgs');
        }

        if($putReq->has('standards')) {
            $group->standards = $putReq->input('standards');
        }

        $group->save();
    }
}
