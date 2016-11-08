<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;
use App\Http\Requests;
use Validator;
use Auth;

class InstructorCoursesController extends Controller
{
    public function index(User $user)
    {
    	$courses = $user->courses;
    	return view('instructor.courses', compact('courses','user'));
    }

    public function store(Request $request, User $user)
    {
        if (!$user || Auth::user() != $user) {
            return back();
        }
        
        $course = new Course($request->all());

        Validator::make($course->toArray(),[
            'title'      =>  'required|unique:courses',
        ])->validate();

    	$user->courses()->save($course);

    	return back();
    }

    public function update(Request $request, User $user, Course $course)
    {
        if (!$user || Auth::user() != $user) {
            return back();
        }

        $updatedCourse = new Course($request->all());

        Validator::make($updatedCourse->toArray(),[
            'title'      =>  'sometimes|required|unique:courses,title,'.$course->id,
        ])->validate();

        $course->update($updatedCourse->toArray());
        
        if ($request->ajax()) {
            return response()->json($course->toArray(),200);
        } else {
            return redirect('/instructor/'.$user->id.'/courses');
        }
    }
}
