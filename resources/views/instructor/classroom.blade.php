@extends('layouts.app')

@section('content')

<div class="container">
	<!-- HEADER SECTION -->
	<section class="page-header">
		<h3>{{$classroom->name}}<br>
			<small>{{$classroom->description}}</small><br>
			<small>Course : <a href="/instructor/{{$user->id}}/courses/{{$classroom->course->id}}/lessons">{{$classroom->course->title}}</a></small>
		</h3>
	</section>

	<section class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				Students
			</div>

			<div class="panel-body">
				@if(count($classroom->students))
				<table class="table" id="tblStudents">
					<thead>
						<th>Name</th>
						<th>Course Progress</th>
						<th>Action</th>
					</thead>

					<tbody>
						@foreach($classroom->students as $student)
						<tr class="studentRecord">
							<td class="studentName">{{$student->getFullName()}}</td>
							<td class="courseProgress">%</td>
							<td>
								<form method="POST" action="{{$classroom->id}}/students/{{$student->id}}">
									{{csrf_field()}}
									{{method_field($student->pivot->isaccepted?'DELETE':'PATCH')}}
									<button type="submit"
									class="btnAction btn btn-{{$student->pivot->isaccepted?'danger':'default'}}">
										{{$student->pivot->isaccepted?'Kick':'Accept Request'}}
									</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@else
				No students enrolled and enrollment requests yet. 
				@endif
			</div>
		</div>

		<div class="panel-body">
			<table></table>
		</div>
	</section>

	<section class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Board
			</div>

			<div class="panel-body">
				Messages...
			</div>
			</div>
	</section>

</div>

@endsection

@section('scripts')

<script src="/js/instructor_classroom.js"></script>

@endsection