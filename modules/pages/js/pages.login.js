$(document).ready(function(){
	$('.loginForm').submit(function(){
		doAjaxReq({
			form: this
		,	msgEl: $(this).find('.loginMsg')
		,	url: getReqUrl('user/login')
		});
		return false;
	});
});