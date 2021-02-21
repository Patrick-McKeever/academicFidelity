<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\classMember;

class AfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Default.
    public function index()
    {
        if(Auth::user()->userType == 'teacher') {
            return view('academicFidelity');
        } else {
            //Get student objects that have been given same email addr as user.
            $reprs = classMember::where('email', Auth::user()->email)->with('class')->get();

            return view('studentView')
                    ->with('reprs', $reprs);
        }
    }
}
