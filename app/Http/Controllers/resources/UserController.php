<?php


namespace App\Http\Controllers\resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //This is preferable to setting a cookie for various reasons.
    public function getUserId() {
        return Auth::user()->id;
    }
}
