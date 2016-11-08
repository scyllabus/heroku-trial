<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();   

        if ($user->isAdmin()) {
            return view('admin.home',compact('user'));
        } else if ($user->isInstructor()) {
            return view('instructor.home',compact('user'));
        } else if ($user->isStudent()) {
            return view('student.home',compact('user'));
        } else {
            return redirect('user/login');
        }
    }
}
