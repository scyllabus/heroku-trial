<?php

namespace App\Http\Controllers;

use App\User;
use App\Classroom;
use App\Course;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Auth;

class InstructorClassroomsController extends Controller
{
    public function index(User $user)
    {
    	$classrooms = $user->classrooms;
    	$courses = Course::accomplished()->get();

    	return view('instructor.classrooms', compact('classrooms','courses','user'));
    }

    public function store(Request $request, User $user)
    {
        if (!$user || Auth::user() != $user) {
             return back();
        }

        $classroom = new Classroom($request->all());

        Validator::make($classroom->toArray(),[
            'name'      =>  'required|unique:classrooms',
            'course_id' => 'required'
        ],
            [
                'name.required'=>'Please provide a unique name for this classroom.',
                'course_id.required'=>'Please provide a course for this classroom.'
            ]
        )->validate();

    	$user->classrooms()->save($classroom);

        if ($request->ajax()) {
            return response()->json($classroom->toArray(),200);
        } else {
            return redirect('/instructor/'.$user->id.'/classrooms');
        }
    }

    public function update(Request $request, User $user, Classroom $classroom)
    {
        if (!$user || Auth::user() != $user) {
             return back();
        }

        $updatedClassroom = new Classroom($request->all());
        
        Validator::make($updatedClassroom->toArray(),[
            'name'      =>  'required|unique:classrooms,name,'.$classroom->id,
        ])->validate();
        
        $classroom->update($updatedClassroom->toArray());

        if ($request->ajax()) {
            return response()->json($classroom->toArray(),200);
        } else {
            return redirect('/instructor/'.$user->id.'/classrooms');
        }
    }

    public function show(Request $request, User $user, Classroom $classroom){
        if (!$user || Auth::user() != $user) {
             return back();
        }

        $classroom->load('students');
        $classroom->load('instructor');
        $classroom->load('course');

        return view('instructor.classroom', compact('classroom','user'));
    }
}
