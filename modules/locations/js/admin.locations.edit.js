$(document).ready(function(){
	$('#saveLocationForm').submit(function(){
		var form = $(this);
		textEditorsSave();
		doAjaxReq({
			form: form
		,	msgEl: $('#saveLocationmMsg')
		,	onSuccess: function(res) {
				if(res.edit_link) {
					redirect( res.edit_link );
				}
			}
		});
		return false;
	});
});