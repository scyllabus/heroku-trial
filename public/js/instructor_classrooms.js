$(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var classroomNameElement = null;
	var classroomDescriptionElement = null;

	//course edit...
	$('.classroomRecord').find('.edit').on('click', function(event){
		event.preventDefault();

		//fetch record to update...
		var record = $(this).closest('tr');
		classroomNameElement = record.find('.name');
		classroomDescriptionElement = record.find('.description');

		var name = classroomNameElement.text();
		var description = classroomDescriptionElement.text();
		
		//set field data...
		$('#txtEditName').val(name);
		$('#txtEditDescription').val(description);
		$('#frmEdit').attr('action','classrooms/'+record.attr('classroomid'));

		//show modal...
		clearErrorDisplays();
		$('#editModal').modal();
	});

	$('#frmEdit').on('submit',function(event){
		event.preventDefault();
		clearErrorDisplays();

		$.ajax({
			method: 'PATCH',
			url: $(this).attr('action'),
			data: {
				name : $('#txtEditName').val(),
				description : $('#txtEditDescription').val(),
			},
			success: function(classroom){
				console.log(classroom);
				$(classroomNameElement).text(classroom.name);
				$(classroomDescriptionElement).text(classroom.description);
				$("#editModal").modal('hide');
			},
			error: function(data){
				console.log(data.responseText);
	            var obj = jQuery.parseJSON(data.responseText);
	            
	            if (obj.name) {
	            	$("#grpEditName").addClass("has-error");
	            	$('#txtEditNameError').text(obj.name);
	            }
	            if (obj.description) {
	            	$("#grpEditDescription").addClass("has-error")
	            	$('#txtEditDescriptionError').text(obj.description);
	            }
			}
		});
	});

	function clearErrorDisplays() {
		$('#txtEditNameError').html("");
	    $('#txtEditDescriptionError').html("");
	    $("#grpEditName").removeClass("has-error");
        $("#grpEditDescription").removeClass("has-error");	
	}
});
