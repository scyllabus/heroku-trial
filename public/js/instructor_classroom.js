$(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('.studentRecord').on('submit','form',function(event){
		$form = $(this);
		methodType = $form.find('input[name=_method]').val();
		studentName = $(this).closest('tr').find('.studentName').html();

		if (methodType == 'DELETE') {
			return confirm('Are you sure you want to kick '+ studentName +' from this class?');
		}
	});

});
