<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;

class AccountController extends Controller
{
    public function index(User $user)
    {
    	// if (!$user || Auth::user()!=$user) {
    	// 	return back();
    	// } else {
    	// 	return view('account',compact('user'));
    	// }
    	return view('account');
    }
}
