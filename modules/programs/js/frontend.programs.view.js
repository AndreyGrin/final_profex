$(document).ready(function(){
	var $container = jQuery('#donateWnd').dialog({
		modal:    true
	,	autoOpen: false
	,	width: 460
	,	height: 400
	});
	$('.helpProgrBtn').click(function(){
		var pid = $(this).data('id');
		$('#donateForm [name=pid]').val(pid);
		$container.dialog('open');
		return false;
	});
	$('#donateForm').submit(function(){
		doAjaxReq({
			form: this
		,	msgEl: $('#donateFormMsg')
		,	onSuccess: function(res) {
				if(!res.errors) {
					reload();
				}
			}
		});
		return false;
	});
});