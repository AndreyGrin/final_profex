$(document).ready(function(){
	$('#saveNewsForm').submit(function(){
		var form = $(this);
		textEditorsSave();
		doAjaxReq({
			form: form
		,	msgEl: $('#saveNewsMsg')
		,	onSuccess: function(res) {
				if(res.edit_link) {
					redirect( res.edit_link );
				}
			}
		});
		return false;
	});
});