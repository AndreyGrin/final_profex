if(typeof(currentProgram) === 'undefined')
	currentProgram = {
		id: 0
	,	files: []
	};
$(document).ready(function(){
	createTextEditor('description');
	$('#saveProgramForm').submit(function(){
		var form = $(this);
		textEditorsSave();
		doAjaxReq({
			form: form
		,	msgEl: $('#saveProgramMsg')
		,	onSuccess: function(res) {
				if(res.program_edit_link) {
					redirect( res.program_edit_link );
				}
				if(res.program) {
					currentProgram = res.program;
				}
			}
		});
		return false;
	});
	rebuildImagesList(currentProgram);
	window.fd.hasConsole = false;
	var uploadFilesUrl = getAdminReqUrl('programs/addImage/'+ currentProgram.id, 'ajax');
	var options = {iframe: {url: uploadFilesUrl}};
	var zone = new FileDrop('uploadFilesShell', options);
	zone.multiple(true);
	
	zone.event('send', function (files) {
		files.each(function (file) {
			file.event('done', function (xhr) {
				var res = JSON.parse(xhr.responseText);
				if(res.file && res.file.id) {
					currentProgram.files.push(res.file);
					rebuildImagesList( currentProgram );
				} else if(res.errors) {
					alert(res.errors.join(', '));
				}
			});

			file.event('error', function (e, xhr) {
				var res = JSON.parse(xhr.responseText);
				if(res.errors) {
					alert(res.errors.join(', '));
				}
			});
			file.sendTo(uploadFilesUrl);
		});
	});
	$('.chosen').chosen();
});
function rebuildImagesList(program) {
	var shell = $('#progrPhotosShell')
	,	example = shell.find('.example')
	,	editForm = $('#saveProgramForm');
	shell.find('.progrPhotoCell:not(.example)').remove();
	editForm.find('input[name="img_id[]"]').remove();
	if(program.files) {
		for(var i in program.files) {
			var newCell = example.clone().removeClass('example');
			newCell.find('.progrPhoto').attr('src', program.files[i].url);
			var removeLink = newCell.find('.progrRemovePhoto');
			removeLink.attr('href', removeLink.attr('href')+ '/'+ program.id+ '/'+ program.files[i].id);
			editForm.append('<input name="img_id[]" type="hidden" value="'+ program.files[i].id+ '" />');
			shell.append( newCell );
		}
	}
}
function removeProgrImg(link) {
	doAjaxReq({
		url: $(link).attr('href')
	,	msgEl: $('<span />').insertAfter(link)
	,	onSuccess: function(res) {
			if(!res.errors) {
				$(link).parents('.progrPhotoCell:first').slideDown(300, function(){
					$(this).remove();
				});
				for(var i in currentProgram.files) {
					if(currentProgram.files[i].id == res.fid) {
						currentProgram.files.splice(i, 1);
						break;
					}
				}
			}
		}
	});
}