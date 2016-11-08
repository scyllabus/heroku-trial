<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Classroom;
use Auth;


class InstructorClassroomStudentsController extends Controller
{
    public function update(Request $request,User $user, Classroom $classroom, User $student)
    {
    	if (!$user || Auth::user() != $user) {
             return back();
        }



        foreach ($classroom->students as $key => $value) {
        	if ($value->id == $student->id) {
        		$value->pivot->isaccepted = 1;
        		$value->pivot->save();
        		break;
        	}
        }

        if ($request->ajax()) {
            return response()->json(['msg'=>'Student enrolled.'],200);
        } else {
            return back();
        }
    }

    public function destroy(Request $request,User $user, Classroom $classroom, User $student)
    {
    	if (!$user || Auth::user() != $user) {
             return back();
        }

        foreach ($classroom->students as $key => $value) {
        	if ($value->id == $student->id) {
        		$classroom->students()->toggle($student->id);
        		break;
        	}
        }

        if ($request->ajax()) {
            return response()->json(['msg'=>'Student kicked.'],200);
        } else {
            return back();
        }
    }
}
