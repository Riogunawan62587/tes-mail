<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    //

    public function index(){
      return User::all();
    }

    public function getSignedInUser(){
      return Auth::user();
    }
}
