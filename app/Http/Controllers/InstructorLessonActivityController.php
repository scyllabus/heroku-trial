<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Course;
use App\Lesson;
use App\ActivitySection;
use App\TestItemType;
use Auth;
use Validator;


class InstructorLessonActivityController extends Controller
{
    public function index(User $user, Course $course, Lesson $lesson)
    {
    	if (!$user || Auth::user() != $user) {
             return back();
        }

        $testItemTypes = TestItemType::all();
        $activity = $lesson->activity->load('sections.items.options');

        return view('instructor.activity', compact('lesson','user','course','activity','testItemTypes'));
    }

    public function update(Request $request, User $user, Course $course, Lesson $lesson)
    {
        if (!$user || Auth::user() != $user) {
            return back();
        }

        $updatedActivity = new Activity($request->all());
        $activity = $lesson->activity;

        $activity->update($updatedActivity->toArray());
        
        if ($request->ajax()) {
            return response()->json($activity->toArray(),200);
        } else {
            return redirect('/instructor/'.$user->id.'/courses/'.$course->id.'/lessons/'.$lesson->id,'/activity');
        }
    
    }  

    public function store(Request $request, User $user, Course $course, Lesson $lesson)
    {
    	if (!$user || Auth::user() != $user) {
             return back();
        }

        $section = new ActivitySection($request->all());

        Validator::make($section->toArray(),[
        	'test_item_type_id' => 'required',
        ],[
        	'instruction.required'=>'Please provide instruction/s for the new section.',
            'test_item_type_id.required'=>'Please choose an item type for the new section.'
        ])->validate();

        $lesson->activity->sections()->save($section);

        if ($request->ajax()) {
        	return response()->json($section->toArray(), 200); 
        } else {
        	return redirect('/instructor/'.$user->id.'/courses/'.$course->id.'/lessons/'.$lesson->id.'/activity');
        }
    }

    public function destroy(Request $request, User $user, Course $course, Lesson $lesson,
            ActivitySection $section
        ){

        if (!$user || Auth::user() != $user) {
             return back();
        }

        $section->delete();

        if ($request->ajax()) {
            return response()->json(['success'=>'Section deleted.'], 200); 
        } else {
            return redirect('/instructor/'.$user->id.'/courses/'.$course->id.'/lessons/'.$lesson->id.'/activity');
        }
    }
}
