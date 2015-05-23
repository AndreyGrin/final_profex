function mailRemoveClick(link) {
	if(confirm(lang('CONFIRM_REMOVE_MAIL'))) {
		var msgEl = $(link).parents('td:first').find('.removeMsg');
		if(!msgEl.size()) {
			msgEl = $('<span class="removeMsg" />').insertAfter(link);
		}
		doAjaxReq({
			url: $(link).attr('href')
		,	msgEl: msgEl
		,	onSuccess: function(res) {
				if(!res.errors) {
					$(link).parents('tr:first').slideDown(300, function(){
						$(this).remove();
					});
				}
			}
		});
	}
}
jQuery(document).ready(function(){
	var mailContentWnd = jQuery('#mailContentWnd').dialog({
		modal:    true
	,	autoOpen: false
	,	width: 460
	,	height: 400
	});
	jQuery('.mailViewContent').click(function(){
		doAjaxReq({
			url: $(this).attr('href')
		,	btn: this
		,	onSuccess: function(res) {
				if(!res.errors) {
					jQuery('#mailContent').html(res.content);
					mailContentWnd.dialog('open');
				}
			}
		});
		return false;
	});
});
