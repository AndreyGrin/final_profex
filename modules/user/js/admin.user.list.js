jQuery(document).ready(function(){
	
});
function userRemoveClick(link) {
	if(confirm(lang('CONFIRM_REMOVE_USER'))) {
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