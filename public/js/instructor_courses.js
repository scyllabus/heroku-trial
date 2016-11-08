$(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var courseTitleElement = null;
	var courseDescriptionElement = null;

	//course edit...
	$('.courseRecord').find('.edit').on('click', function(event){
		event.preventDefault();
		
		//fetch record to update...
		var record = $(this).closest('tr');
		courseTitleElement = record.find('.title');
		courseDescriptionElement = record.find('.description');
		
		var title = courseTitleElement.text();
		var description = courseDescriptionElement.text();
		
		//set field data...
		$('#txtEditTitle').val(title);
		$('#txtEditDescription').val(description);
		$('#frmEdit').attr('action','courses/'+record.attr('courseid'));

		//show modal...
		clearErrorDisplay();
		$('#editModal').modal();
	});

	$('#frmEdit').on('submit',function(event){
		event.preventDefault();
		clearErrorDisplay();
		
		$.ajax({
			method: 'PATCH',
			url: $(this).attr('action'),
			data: {
				title : $('#txtEditTitle').val(),
				description : $('#txtEditDescription').val(),
			},
			success: function(course){
				console.log(course);
				$(courseTitleElement).text(course.title);
				$(courseDescriptionElement).text(course.description);
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

	function clearErrorDisplay() {
		$('#txtEditTitleError').html("");
	    $('#txtEditDescriptionError').html("");
	    $("#grpEditTitle").removeClass("has-error");
        $("#grpEditDescription").removeClass("has-error");
	}

});
