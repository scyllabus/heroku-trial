@extends('layouts.app')

@section('content')
<div class="container">
	<section class="page-header">
		<a href="{{$lesson->id}}/activity">
		<button class="btn btn-success pull-right">
			@if($lesson->activity->isAccomplished)
				View
			@else
				Design
			@endif
			 Activity
		</button>
		</a>
		<h3>{{$lesson->title}}<br>
			<h5><i>{{$course->title}} lesson # {{$lesson->order}}</i></h5>
			<small>{{$lesson->description}}</small>
		</h3>
	</section>

	<section>
		<header>
			<button class="btn btn-default pull-right">Add Lecture</button>
			<h3>Lectures</h3>
		</header>
		<br>
		<ul>
			<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
			<li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
		</ul>
	</section>
</div>
@endsection