<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvaluationPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Default.
    public function index()
    {
        return view('evaluationPortal');
    }
}
