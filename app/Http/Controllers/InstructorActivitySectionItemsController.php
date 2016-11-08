<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TestItemType;
use App\TestItem;
use App\ActivitySection;
use App\TestItemOption;

class InstructorActivitySectionItemsController extends Controller
{
    public function store(Request $request)
    {
    	$section = ActivitySection::find($request->input('section_id'));
    	$itemType = $section->type;

    	$content = collect($request->input('content'))->filter(function ($value, $key) {
		    return (!(empty(trim($value))));
		});

		$answers = collect($request->input('answers'))->filter(function ($value, $key) {
		    return (!(empty(trim($value))));
		});

		$options = collect($request->input('options'))->filter(function ($value, $key) {
		    return (!(empty(trim($value))));
		});

		$tofanswer = collect($request->input('tofanswer'))->filter(function ($value, $key) {
		    return (!(empty(trim($value))));
		});

		//Validation here...
		$errorMessage = array();

		$itemTypeName = $itemType->name;
		switch ($itemType->name) {
    		case 'identification':
    		case 'enumeration':
    		case 'multiple choice':
    			if (count($answers) <= 0) {
	    			$errorMessage["answers"] = "Please provide answer(s) to this item.";
				}
				if($itemTypeName == "multiple choice" && count($options) <= 0){
					$errorMessage["options"] = "Please provide some options for this item.";
				}
    			break;
    		case 'true or false':
    			if (count($tofanswer) <= 0) {
					$errorMessage["tofanswer"] = "Please choose an answer to this item.";
				}
				break;
    		default:
    			$errorMessage["dataType"] = "Content is required.";
    			break;
    	}

		if (count($content) <= 0) {
			$errorMessage["content"] = "Content is required.";
		}

    	if (count($errorMessage) > 0) {
    		return response()->json($errorMessage, 400);
    	}

    	//Item creation...
    	$newItem = new TestItem();
    	$newItem->content = $content->first();
    	$newItem->course_id = $section->activity->lesson->course->id;
    	$newItem->test_item_type_id = $itemType->id;

    	if($newItem->save()){
    		$itemTypeName = $itemType->name;
    		switch ($itemTypeName) {
	    		case 'identification':
	    		case 'enumeration':
	    		case 'multiple choice':
	    			foreach ($answers as $key => $value) {
	    				$newItem->options()->save(new TestItemOption(['content'=>$value,'iscorrect'=>1]));
	    			}

	    			if ($itemTypeName == 'multiple choice') {
	    				foreach ($options as $key => $value) {
	    					$newItem->options()->save(new TestItemOption(['content'=>$value,'iscorrect'=>0]));
	    				}
	    			}
	    			break;
	    		case 'true or false':
	    			$t = new TestItemOption(['content'=>'True','iscorrect'=>
	    					(strtolower($tofanswer->first()) == 'true'?1:0)
	    				]);
	    			$f = new TestItemOption(['content'=>'False','iscorrect'=>
	    					(strtolower($tofanswer->first()) == 'false'?1:0)
	    				]);

	    			$newItem->options()->save($t);
	    			$newItem->options()->save($f);
	    			break;
	    		default:
	    			return 'Invalid item type.';
	    			break;
    		}

    		$section->items()->toggle($newItem->id);
    		return response()->json($newItem->load('options'),200);
    	}
    }

    public function destroy(Request $request, TestItem $item)
    {
    	if (!$user || Auth::user() != $user) {
             return back();
        }

        $section = ActivitySection::findOrFail($request->input('section-id'));
        $section->items()->toggle($item->id);

        if ($request->ajax()) {
            return response()->json(['success'=>'Item removed.'], 200); 
        } else {
            return back();
        }
    }
}