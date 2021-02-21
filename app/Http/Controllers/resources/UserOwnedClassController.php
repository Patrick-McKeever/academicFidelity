<?php

namespace App\Http\Controllers\resources;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\userOwnedClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserOwnedClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //List classes owned by user with boolean value of "archived".
    public function index(bool $archived)
    {
        $user = Auth::user();
        $classes = $user->classes->where('archived', $archived);
        return response()->json($classes);
    }

    //Show json data for specific class.
    public function show($classId)
    {
        //the "with" clause returns a 1-el array, so we need to select the first.
        $class = userOwnedClass::with('owner', 'students', 'shares', 'spreadsheets')->get()
                                ->where('id', $classId)->first();
        $this->authorize('view', $class);
        return response()->json($class);
    }

    //Make new class given post data.
    public function store(Request $postReq)
    {
        $this->authorize('create', userOwnedClass::class);
        userOwnedClass::create([
            'name' => $postReq->input('className'),
            'ownerId' => Auth::user()->id
        ]);
    }

    //Update existing class.
    public function update(Request $putReq)
    {
        $classId = $putReq->input('id');
        $class = userOwnedClass::find($classId);
        $this->authorize('update', $class);

        $class->name = $putReq->input('name');
        $class->archived = $putReq->input('archived');
        $class->save();
    }
}
