$(document).ready(function(){
	$('#saveCategoryForm').submit(function(){
		var form = $(this);
		textEditorsSave();
		doAjaxReq({
			form: form
		,	msgEl: $('#saveCategorymMsg')
		,	onSuccess: function(res) {
				if(res.edit_link) {
					redirect( res.edit_link );
				}
			}
		});
		return false;
	});
});