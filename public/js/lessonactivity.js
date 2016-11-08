$(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	//POST ACTIVITY SECTION...
	$("#btnPostActivity").on('click', function(event){
		var confirmed = confirm("This action is irreversible! \n\nAre you sure you want to post this activity?");
		if (confirmed) {
			
			var url = window.location.pathname;

			$.ajax({
				method: 'PATCH',
				url: url,
				data: {
					accomplished : 1
				},
				success: function(activity){
					console.log(activity);
					location.reload();
				},
				error: function(data){
					console.log(data);
					alert('Failed to commit activity.');
				}
			});
		}
	});

	//ADDING NEW ITEM SECTION...
	$('.sectionRecord').find('.addNewItem').on('click', function(event){
		event.preventDefault();
		var section = $(this).closest('tr');
		clearErrorDisplay();
		setNewItemModal(section);
		$('#addNewItemModal').modal();
	});

	function setNewItemModal(section) {
		var $form = $('#frmEdit');

		var $grpAnswers = $form.find('#grpNewAnswers');
		var $grpOptions = $form.find('#grpNewOptions');
		var $grpTOF = $form.find('#grpTrueOrFalse');
		var $btnAddAnswer = $form.find('#btnAddAnswer');

		$.each($grpAnswers.find('.answer'), function(index,object){
			if (index > 0) {
				object.remove();
			} else {
				$(this).find('input').val('');
			}
		});

		$.each($grpOptions.find('.option'), function(index,object){
			if (index > 0) {
				object.remove();
			} else {
				$(this).find('input').val('');
			}
		});

		var sectionType = section.attr('section-type');
		console.log(sectionType);
		switch(sectionType){
			case 'identification':
				$grpAnswers.show();
				$btnAddAnswer.hide();
				$grpOptions.hide();
				$grpTOF.hide();
				break;
			case 'true or false':
				$grpAnswers.hide();
				$grpOptions.hide();
				$grpTOF.show();
				break;
			case 'multiple choice':
				$grpOptions.show();
				$grpAnswers.show();
				$btnAddAnswer.hide();
				$grpTOF.hide();
				break;
			case 'enumeration':
				$grpAnswers.show();
				$btnAddAnswer.show();
				$grpOptions.hide();
				$grpTOF.hide();
				break;
		}

		$('#item-type').attr('value',section.attr('section-type-id'));
		$('#section-id').attr('value',section.data('itemid'));
		$('#txtNewContent').val('');
	}

	//ADDING ITEM FROM QUESTION BANK SECTION...
	$('.sectionRecord').find('.addItemFromQB').on('click', function(event){
		event.preventDefault();
		alert('Adding item from QB...');
	});

	//ADDING ANSWER AND OPTION...
	$('#btnAddAnswer').on('click',function(event){
		event.preventDefault();
		console.log('Adding another answer...');
		$(this).before('<div class="answer form-group form-inline"><input class="form-control" type="text" name="answers[]" placeholder="Answer."> <button class="btn btn-default removeAnswer">X</button></div>');
	});

	$('#btnAddOption').on('click',function(event){
		event.preventDefault();
		console.log('Adding another option...');
		$(this).before('<div class="option form-group form-inline"><input class="form-control" type="text" name="options[]" placeholder="Option."> <button class="btn btn-default removeOption">X</button></div>');
	});

	$('#frmEdit').on('click','.removeAnswer',function(event){
		event.preventDefault();
		console.log('Removing answer...');
		if($('#grpNewAnswers').find('.answer').length > 1){
			$(this).prev().remove();
			$(this).remove();
		} 
	});

	$('#frmEdit').on('click','.removeOption',function(event){
		event.preventDefault();
		console.log('Removing option...');
		if($('#grpNewOptions').find('.option').length > 1){
			$(this).prev().remove();
			$(this).remove();
		} 
	});

	//DELETING SECTION RECORD...
	$('.sectionRecord').find('.delete').on('submit', function(event){
		event.preventDefault();

		if (confirm('Are you sure you want to delete this section?')) {
			$form = $(this);
			$.ajax({
				method: $form.attr('method'),
				url: $form.attr('action'),
				data: $form.serialize(),
				success: function(data){
					$form.closest('tr').fadeOut('slow', function(){
						$form.closest('tr').remove();
					});
				},
				error: function(data){ 
					alert('Failed to delete section.');
					console.log(data);
				}
			});
		}
	});

	$('#frmEdit').on('submit',function(event){
		event.preventDefault();
		
		clearErrorDisplay();
		$form = $(this);

		$.ajax({
			method: $form.attr('method'),
			url: $form.attr('action'),
			dataType: 'json',
			data:$form.serialize(),
			success: function(data){
				location.reload();
			},
			error: function(data){ 
				console.log(data);
				if (data.responseText) {
		            var obj = jQuery.parseJSON(data.responseText);
		            
		            if (obj.answers) {
		            	$("#grpNewAnswers").addClass("has-error");
		            	$('#txtNewAnswersError').text(obj.answers);
		            }
		            if (obj.options) {
		            	$("#grpNewOptions").addClass("has-error")
		            	$('#txtNewOptionsError').text(obj.options);
		            }
		            if (obj.content) {
		            	$("#grpNewContent").addClass("has-error")
		            	$('#txtNewContentError').text(obj.content);
		            }
		            if (obj.tofanswer) {
		            	$("#grpTrueOrFalse").addClass("has-error");
		            	$('#txtNewTOFError').text(obj.tofanswer);
		            }
	            }
			}
		});
	});

	function clearErrorDisplay() {
		$('#txtNewAnswersError').html("");
		$('#txtNewOptionsError').html("");
		$('#txtNewContentError').html("");
		$('#txtNewTOFError').html("");

	    $("#grpNewAnswers").removeClass("has-error");
	    $("#grpNewOptions").removeClass("has-error");
	    $("#grpNewContent").removeClass("has-error");
	    $("#grpTrueOrFalse").removeClass("has-error")
	}
	
});