@extends('layouts.app')

@section('content')
<div class="container">
	<!-- PAGE HEADER -->
	<section class="page-header">
		@unless($activity->accomplished)
			<button id="btnPostActivity" class="btn btn-danger pull-right">Post Activity</button>
		@endunless
		</a>
		<h3>Activity for {{$lesson->title}}<br>
			<h5><i>{{$course->title}} lesson # {{$lesson->order}}</i></h5>
			<small>{{$lesson->description}}</small>
		</h3>
	</section>

	<!-- ADD SECTION -->
	<section class="col-md-4">
		<h3>New Section</h3>
		@if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
		<form id="frmNew" method="POST" action="/instructor/{{$user->id}}/courses/{{$course->id}}/lessons/{{$lesson->id}}/activity/sections">
            {{csrf_field()}}
            <div id="grpNewInstruction" class="form-group">
                <label class="control-label" for="txtNewInstruction">Instruction</label>
                <textarea class="form-control" id="txtNewInstruction" placeholder="Section's instruction." name="instruction">{{old('instruction')}}</textarea>
            </div>

            <div id="grpNewInstruction" class="form-group">
                <label class="control-label" for="txtNewTitle">Item Type</label><br>
                <select id="selSectionItemType" title="Type" name="test_item_type_id" required>
                	<option value>-- Choose Item Type --</option>
                	@foreach($testItemTypes as $itemtype)
                		<option value="{{$itemtype->id}}">{{title_case($itemtype->name)}}</option>
                	@endforeach
                </select>
            </div>

            <button class="btn btn-primary" type="submit">Save</button>
        </form>
	</section>

	<!-- SECTION LIST -->
	<section class="col-md-8">
		<h3>Activity Section List</h3>

		@if(!$activity->sections->count())
			No sections declared yet.
		@else
			<table id="" class="table">
            <tbody class="sortable" data-entityname="activitysection">
            @foreach($activity->sections()->sorted()->get() as $section)
            <!-- SECTION RECORD -->
            <tr class="sectionRecord" section-type-id="{{$section->type->id}}" section-type="{{$section->type->name}}" data-itemId="{{ $section->id }}">
            	<td hidden class="id-column">{{{ $section->id }}}</td>
            	<td>
	            	<div class="panel panel-default">
	            		<!-- SECTION RECORD HEADER -->
	            		<div class="panel-heading">
	            			@if(!$activity->accomplished)
	            			<form class="delete pull-right" title="Delete section." method="POST" 
	            			action="activity/sections/{{$section->id}}">
		            			{{ csrf_field() }}
		            			{{ method_field('DELETE') }}
		            			<button title="Delete section." type="submit" class="pull-right btn btn-default"> <span class="glyphicon glyphicon-trash"></span></button>
		            		</form>
	            			
	            			<div class="btn-group pull-right">
								<button type="button" class="btn btn-default dropdown-toggle"
								data-toggle="dropdown">
								<span class="glyphicon glyphicon-plus"></span> Add Item
								</button> 
								<ul class="dropdown-menu" role="menu">
									<li><a class="addNewItem" href="">Create New</a></li>
									<li><a class="addItemFromQB" href="">From Question Bank</a></li>
								</ul>
							</div>
	            			<h4>{{{title_case($section->type->name)}}}</h4>
							@else
								<h4>Section {{$section->order}}</h4>
							@endif
	            		</div>

	            		
	            		<!-- SECTION RECORD BODY -->
            			<div class="panel-body">
	            			<table class="table">
	            				<tbody class="sortable" data-entityname="activitysectionItems">
	            				@if(!$section->items->count())
	            					<small>No items yet.</small>
	            				@else

	            				@foreach($section->items as $item)
		            				<tr data-itemId="{{ $item->id }}" data-parentId="{{ $section->id }}">
	        							<td hidden class="id-column">{{$item->id}}</td>

	        							<!-- ITEM CONTENT HERE -->
	        							<td>{{$item->content}}<br>
	        								@if($item->type->name == 'enumeration' || $item->type->name == 'identification')

	        								<strong>{{{ $item->options->implode('content',', ') }}}</strong>

	        								@elseif($item->type->name == 'multiple choice' || $item->type->name == 'true or false')
	        									
	        									@foreach($item->options as $option)
    											<input type="checkbox"  disabled {{$option->iscorrect?'checked':''}}>
    											 {{{ $option->content }}}
		                                    	@endforeach
		                                    	
	        								@endif
        								</td>
	        							
	        							@unless($activity->accomplished)
	        							<td>
	        							<!-- <form class="remove pull-right" title="Delete section." method="POST" 
				            			action="/instructor/activitysectionitems/{{$item->id}}">
					            			{{ csrf_field() }}
					            			{{ method_field('DELETE') }}
					            			<input type="hidden" name="section-id" value="{{$section->id}}">
					            			<button title="Delete section." type="submit" class="pull-right btn btn-default"> <span class="glyphicon glyphicon-remove"></span></button>
					            		</form> -->
					            			<button title="Delete section." type="button" class="pull-right btn btn-default"> <span class="glyphicon glyphicon-remove"></span></button>
	        							</td>
		            					<td class="sortable-handle" align="center" style="vertical-align:middle;"><span class="glyphicon glyphicon-sort"></span></td>
		            					@endunless
		            				</tr>
	            				@endforeach
	            				@endif
	            				</tbody>
	            			</table>
	            		</div>
	            	</div>
            	</td>
            	@if(!$activity->accomplished)
            	<td class="sortable-handle" align="center" style="vertical-align:middle;"><span class="glyphicon glyphicon-sort"></span></td>
            	@endif
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
	</section>

	<!-- ADD ITEM MODAL -->
	    <div class="modal fade" id="addNewItemModal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		        <h4 class="modal-title">New Item</h4>
		      </div>
		      <div class="modal-body">
		        <form id="frmEdit" action="/instructor/activitysectionitems" method="POST">
	        		{{ csrf_field()}}

	        		<input id="section-id" type="hidden" name="section_id" value="">
		  			<div id="grpNewContent" class="form-group">
			        	<label class="control-label" for="txtNewContent">Content</label>
			        	<textarea class="form-control" id="txtNewContent" type="text" name="content" placeholder="Item question/hint/problem."></textarea>
			        	<span class=
                        "help-block">
                        <strong id="txtNewContentError"></strong></span>
		        	</div>

		        	<div id="grpNewAnswers" class="form-group">
		        		<label class="control-label">Answer</label>
		        		<span class="help-block">
	                        <strong id="txtNewAnswersError"></strong></span>
		        		<div class="answer form-group form-inline">
				        	<input class="form-control" type="text" name="answers[]" placeholder="Answer." >
			        	</div>
                        <button id="btnAddAnswer" class="btn btn-default">Add an Answer</button>
		        	</div>

		        	<div id="grpNewOptions" class="form-group">
		        		<label class="control-label">Options</label>
		        		<span class="help-block">
	                        <strong id="txtNewOptionsError"></strong></span>

	                    <div class="option form-group form-inline">
				        	<input class="form-control" type="text" name="options[]" placeholder="Option.">
			        	</div>

			        	<button id="btnAddOption" class="btn btn-default">Add an Option</button>
		        	</div>

		        	<div id="grpTrueOrFalse" class="form-group">
		        		<span class="help-block">
	                        <strong id="txtNewTOFError"></strong></span>
		        		<label class="control-label">Answer</label><br>
		        		<label class="radio-inline">
                        <input type="radio" name="tofanswer" value="True" checked="checked">True</label>
                        <label class="radio-inline">
                        <input type="radio" name="tofanswer" value="False">False</label>
		        	</div>

		    		<button type="submit" class="btn btn-primary">Save</button>
		        </form>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
</div>
@endsection

@section('scripts')
	<script src="/js/lessonactivity.js"></script>
	<script src="/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="/js/sortable.js"></script>
@endsection