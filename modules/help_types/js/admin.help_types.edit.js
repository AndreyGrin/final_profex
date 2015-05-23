$(document).ready(function(){
	$('#saveHelpTypeForm').submit(function(){
		var form = $(this);
		textEditorsSave();
		doAjaxReq({
			form: form
		,	msgEl: $('#saveHelpTypemMsg')
		,	onSuccess: function(res) {
				if(res.edit_link) {
					redirect( res.edit_link );
				}
			}
		});
		return false;
	});
});