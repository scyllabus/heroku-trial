<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Course;
use App\User;
use App\Lesson;
use App\Activity;
use Validator;
use Auth;
use Rule;


class InstructorCourseLessonsController extends Controller
{
    public function index(User $user,Course $course)
    {
    	if (!$user || Auth::user() != $user) {
             return back();
        }
        
        $lessons = $course->lessons()->sorted()->get();
        
        return view('instructor.courselessons', compact('lessons','user','course'));
    }

    public function store(Request $request, User $user, Course $course)
    {
    	if (!$user || Auth::user() != $user) {
             return back();
        }

        $lesson = new Lesson($request->all());

        Validator::make($lesson->toArray(),[
        	'title' => 'required|unique:lessons'
        ],[
        	//'title.required'=>"Must provide a title."
        ])->validate();

        $course->lessons()->save($lesson);
        $lesson->activity()->save(new Activity());

        if ($request->ajax()) {
        	return response()->json($lesson->toArray(), 200); 
        } else {
        	return redirect('/instructor/'.$user->id.'/courses/'.$course->id.'/lessons');
        }
    }

    public function update(Request $request, User $user, Course $course, Lesson $lesson)
    {
    	if (!$user || Auth::user() != $user) {
            return back();
        }

        $updatedLesson = new Lesson($request->all());

        Validator::make($updatedLesson->toArray(),[
            'title'      =>  'required|unique:lessons,title,NULL,id,course_id,'.$course->id,
        ])->validate();

        $lesson->update($updatedLesson->toArray());
        
        if ($request->ajax()) {
            return response()->json($lesson->toArray(),200);
        } else {
            return redirect('/instructor/'.$user->id.'/courses/'.$course->id.'lessons');
        }
    
	}	

    public function show(User $user, Course $course, Lesson $lesson)
    {   
        if (!$user || Auth::user() != $user) {
            return back();
        }

        return view('instructor.lesson', compact('lesson','course','user'));
    }
    
}
