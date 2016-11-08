@extends('layouts.app')

@section('content')
	<div class="container">
		
		<div class="row">

		<!-- NEW COURSE SECTION -->
	    <section class="col-md-3">
	    	<h3>New Course</h3>
	    	@if (count($errors) > 0)
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
	    	<form id="frmNew" method="POST" action="/instructor/{{$user->id}}/courses">
    		{{csrf_field()}}

    		<div id="grpNewTitle" class="form-group">
	    		<label class="control-label" for="txtNewTitle">Title</label>
	    		<input class="form-control" id="txtNewTitle" type="text" name="title" placeholder="A unique title."
	    		 value="{{ old('title')}}">
    		</div>

		<div id="grpNewDescription" class="form-group">
    		<label class="control-label" for="txtNewDescription">Description</label>
    		<textarea class="form-control" id="txtNewDescription" placeholder="A short course description." name="description">{{old('description')}}</textarea>
    		</div>

    		<button type="submit" class="btn btn-primary">Save</button>
    	</form>
	    </section>

	    <!-- COURSE LIST SECTION -->
	    <section class="col-md-9">
	    	<h3>Courses</h3>
	    	@if($courses->count() <=0)
	    		<span>No course record yet.</span>
	    	@else
	    		<table class="table">
	    			<thead>
		    			<tr>
		    				<th>Title</th>
		    				<th>Description</th>
		    				<th>Action</th>
		    				<th>Status</th>
		    			</tr>
	    			</thead>
	    			<tbody>
		    		@foreach($courses as $course)
		    			<tr class="courseRecord" courseid="{{$course->id}}">
		    				<td class="title">{{$course->title}}</td>
		    				<td class="description">{{$course->description}}</td>
		    				<td>
		    					<button class="btn btn-default edit" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
		    					<a class="btn btn-default" href="courses/{{$course->id}}/lessons" role="button" title="View Lessons">
		    						View
		    					</a>
		    				</td>
		    				<td>{{$course->accomplished?'Accomplished':'Designing'}}</td>
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
		        <h4 class="modal-title">Edit Course</h4>
		      </div>
		      <div class="modal-body">
		        <form id="frmEdit">
		        	{{ method_field('PATCH')}}
	        		{{ csrf_field()}}
		  			<div id="grpEditTitle" class="form-group">
			        	<label class="control-label" for="txtEditTitle">Title</label>
			        	<input class="form-control" id="txtEditTitle" type="text" name="title" placeholder="A unique title.">
			        	<span class=
                        "help-block">
                        <strong id="txtEditTitleError"></strong></span>
		        	</div>

		        	<div id="grpNewDescription" class="form-group">
			        	<label class="control-label" for="txtEditDescription">Description</label>
			    		<textarea class="form-control" id="txtEditDescription" placeholder="A short course description." name="description"></textarea>
			    		<span class=
                        "help-block">
                        <strong id="txtEditDescriptionError"></strong></span>
		    		</div>

		    		<button type="submit" class="btn btn-primary">Save changes</button>
		        </form>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<script>
			var token = '{{ Session::token() }}';
		</script>

		<script src="/js/instructor_courses.js"></script>
	</div>
@endsection
