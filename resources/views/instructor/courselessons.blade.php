@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

    <!-- HEADER SECTION -->
    <section class="page-header">
        @if(!$course->accomplished)
            <button id="btnCommitLessonPlan" class="btn btn-danger pull-right">Commit Lesson Plan</button>
        @endif
        <h3>{{$course->title}}<br>
            <small>{{$course->description}}</small>
        </h3>
    </section>

    <!-- NEW LESSON SECTION -->
    <section class="col-md-3">
        <h3>New Lesson</h3>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="frmNew" method="POST" action="/instructor/{{$user->id}}/courses/{{$course->id}}/lessons">
            {{csrf_field()}}

            <div id="grpNewName" class="form-group">
                <label class="control-label" for="txtNewTitle">Title</label>
                <input class="form-control" id="txtNewTitle" type="text" name="title" placeholder="A unique title." value="{{old('title')}}">
            </div>

            <div id="grpNewDescription" class="form-group">
                <label class="control-label" for="txtNewDescription">Description</label>
                <textarea class="form-control" id="txtNewDesription" placeholder="Lesson's overview." name="description">{{old('description')}}</textarea>
            </div>

            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </section>

    <!-- SYLLABUS SECTION -->
    <section class="col-md-9">
    	<h3>Lessons</h3>
        @if(!$lessons->count())
            No lesson record yet.
        @else
    	<table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                    @unless($course->accomplished)
                    <th class="sortable-handle-col"></th>
                    @endunless
                </tr>
            </thead>
            <tbody class="sortable" data-entityname="lesson">
            @foreach ($lessons as $lesson)
            <tr  class="lessonRecord" data-itemId="{{{ $lesson->id }}}" lessonid="{{ $lesson->id }}">
                <td hidden class="id-column">{{{ $lesson->id }}}</td>
                <td class="title">{{{ $lesson->title }}}</td>
                <td class="description">{{{ $lesson->description }}}</td>
               
                <td class="#sortable-handle-col">
                    <button class="btn btn-default edit" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                    <a class="btn btn-default" href="lessons/{{$lesson->id}}" role="button" title="View Lessons">
                        View
                    </a>
                </td>
                
                @unless($course->accomplished)
                <td title="Drag to reorder." class="sortable-handle"><span class="glyphicon glyphicon-sort"></span></td>
                @endunless
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
            <h4 class="modal-title">Edit Lesson</h4>
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

                <div id="grpEditDescription" class="form-group">
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
</div>
    
    <script src="/js/courselessons.js"></script>
@if(!$course->accomplished)
    <script src="/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="/js/sortable.js"></script>
@endif
	
@endsection