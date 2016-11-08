$(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var lessonTitleElement = null;
	var lessonDescriptionElement = null;

	//course edit...
	$('.lessonRecord').find('.edit').on('click', function(event){
		event.preventDefault();
		
		//fetch record to update...
		var record = $(this).closest('tr');
		lessonTitleElement = record.find('.title');
		lessonDescriptionElement = record.find('.description');
		
		var title = lessonTitleElement.text();
		var description = lessonDescriptionElement.text();
		
		//set field data...
		$('#txtEditTitle').val(title);
		$('#txtEditDescription').val(description);
		$('#frmEdit').attr('action','lessons/'+record.attr('lessonid'));

		//show modal...
		clearErrorsDisplays();
		$('#editModal').modal();
	});

	$('#frmEdit').on('submit',function(event){
		event.preventDefault();
		clearErrorsDisplays();

		$.ajax({
			method: 'PATCH',
			url: $(this).attr('action'),
			data: {
				title : $('#txtEditTitle').val(),
				description : $('#txtEditDescription').val(),
			},
			success: function(course){
				console.log(course);
				$(lessonTitleElement).text(course.title);
				$(lessonDescriptionElement).text(course.description);
				$("#editModal").modal('hide');
			},
			error: function(data){
				console.log(data.responseText);
	            var obj = jQuery.parseJSON(data.responseText);
	            
	            if (obj.title) {
	            	$("#grpEditTitle").addClass("has-error");
	            	$('#txtEditTitleError').text(obj.title);
	            }
	            if (obj.description) {
	            	$("#grpEditDescription").addClass("has-error")
	            	$('#txtEditDescriptionError').text(obj.description);
	            }
			}
		});
	});

	$("#btnCommitLessonPlan").on('click', function(event){
		var confirmed = confirm("Committing lesson plan will disable lesson reordering but makes the course usable for classroom creation.\n\nAre you sure you want to commit this lesson plan?");
		if (confirmed) {
			
			var url = (window.location.pathname).replace('/lessons','');

			$.ajax({
				method: 'PATCH',
				url: url,
				data: {
					accomplished : 1
				},
				success: function(course){
					console.log(course);
					alert('Lesson plan committed.');
					$("#btnCommitLessonPlan").fadeOut('fast').remove();
					$(".sortable-handle-col").fadeOut('fast').remove();
					$(".sortable-handle").fadeOut('fast').remove();
				},
				error: function(data){
					console.log(data);
					alert('Failed to commit lesson plan.');
				}
			});
		}
	});

	function clearErrorsDisplays(){
		$('#txtEditTitleError').html("");
	    $('#txtEditDescriptionError').html("");
	    $("#grpEditTitle").removeClass("has-error");
        $("#grpEditDescription").removeClass("has-error");
	}

});
