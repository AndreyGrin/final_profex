$(document).ready(function(){
	var $subscribeWnd = jQuery('#subscribeWnd').dialog({
		modal:    true
	,	autoOpen: false
	,	width: 460
	,	height: 400
	});
	$('.subscribeBtn').click(function(){
		var pid = jQuery(this).data('pid');
		if(g_isLoggedIn) {
			var link = jQuery(this);
			if(!link.hasClass('subscribedBtn')) {
				doAjaxReq({
					btn: this
				,	url: link.attr('href')
				,	onSuccess: function(res) {
						if(!res.error) {
							link.html(res.msg).addClass('subscribedBtn');
						}
					}
				});
			}
		} else {
			jQuery('.subscribeForm').find('input[name=pid]').val( pid );
			$subscribeWnd.dialog('open');
		}
		return false;
	});
	$('body').on('submit', '.subscribeForm', function(){
		var form = this;
		doAjaxReq({
			form: this
		,	msgEl: $(this).find('.subscribeMsg')
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery(form).find('*:not(.subscribeMsg)').slideUp( 300 );
					reload();
				}
			}
		});
		return false;
	});
});