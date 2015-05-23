jQuery(document).ready(function(){
	jQuery('.profileForm').submit(function(){
		doAjaxReq({
			form: this
		,	msgEl: $(this).find('.profileFormMsg')
		});
		return false;
	});
	jQuery('.unsubscribeBtn').click(function(){
		var btn = this;
		doAjaxReq({
			url: jQuery(this).attr('href')
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery(btn).parents('.subscriptionRow:first').slideUp(300, function(){
						jQuery(btn).parents('.subscriptionRow:first').remove();
					});
				}
			}
		});
		return false;
	});
});