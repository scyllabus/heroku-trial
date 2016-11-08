@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
	<!--NEW CLASSROOM FORM-->
    <section class="col-md-3">
    	<h3>New Classroom</h3>
    	@if (count($errors) > 0)
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

    	<form id="frmNew" method="POST" action="/instructor/{{$user->id}}/classrooms">
    		{{csrf_field()}}

    		<div id="grpNewName" class="form-group">
	    		<label class="control-label" for="txtNewName">Name</label>
	    		<input class="form-control" id="txtNewName" type="text" name="name" placeholder="A unique name." value="{{old('name')}}">
    		</div>

    		<div id="grpNewDescription" class="form-group">
	    		<label class="control-label" for="txtNewDescription">Description</label>
	    		<textarea class="form-control" id="txtNewDesription" placeholder="A short classrooom description." name="description">{{old('description')}}</textarea>
    		</div>

    		<div id="grpNewCourse" class="form-group">
	    		<label class="control-label" for="optNewCourse">Course</label><br>
	    		@if(!$courses->count())
	    			<i>No accomplished course record yet. Create 
	    			<a href="/instructor/{{$user->id}}/courses">here</a>.</i>
	    		@else
	    			<select class="form-cotrol" id="optNewCourse" name="course_id">
	    			<option value> Select a course </option>
	    			@foreach($courses as $course)
						<option value="{{ $course->id }}">
							{{ $course->title }}
						</option>
					@endforeach
		    		</select>
	    		@endif
    		</div>

    		<button class="btn btn-primary" type="submit">Save</button>
    	</form>
    </section>


	<!--CLASSROOM LIST SECTION-->
    <section class="col-md-9">
		<h3>Classrooms</h3>
			@if(!$classrooms->count())
				<span id="noClassroomMessage">No classroom record yet.</span>
			@else
				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th>Course</th>
							<th>Date Created</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					@foreach($classrooms as $classroom)
						<tr class="classroomRecord" classroomid="{{ $classroom->id }}">
							<td class="name">{{$classroom->name}}</td>
							<td class="description">{{$classroom->description}}</td>
							<td class="course">{{$classroom->course->title}}</td>
							<td class="create_at">{{$classroom->created_at->toFormattedDateString()}}</td>
							<td>{{$classroom->isactive?'Registered':'For Application'}}</td>
							<td><button class="btn btn-default edit" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
							@if($classroom->isactive)
								<a href="classrooms/{{$classroom->id}}"><button class="btn btn-default view" title="View Classroom">View</span></button></a>
							@endif
							</td>
							
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
    </section>
	</div>    

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		        <h4 class="modal-title">Edit Classroom</h4>
		      </div>
		      <div class="modal-body">
		        <form id="frmEdit" action="">
	        		{{ method_field('PATCH')}}
	        		{{ csrf_field()}}
                    <div class="form-group" id="grpEditName">
                        <label class="control-label" for="txtEditName">Name</label>
                        <input class="form-control" id="txtEditName" name="name"
                        placeholder="Choose a unique name" required="" title="Please enter the classroom name" type="text">
                        <span class=
                        "help-block">
                        <strong id="txtEditNameError"></strong></span>
                    </div>

                    <div class="form-group" id="grpEditDescription">
                        <label class="control-label" for="txtEditDescription">Description</label>
                        <textarea class="form-control" id="txtEditDescription" name="description"  placeholder="A short classroom description." title="Keep it short and simple."></textarea> 
                      	<span class="help-block"><strong id="txtEditDescriptionError"></strong></span>
                    </div>

		       		<button type="submit" class="btn btn-primary ">Save changes</button>
                </form>
		      </div>
		        
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<script src="/js/instructor_classrooms.js"></script>
</div>

@endsection