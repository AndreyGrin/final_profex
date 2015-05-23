/**
 * Shell function for ajax calls
 */
function doAjaxReq(params) {
	params = params || {};
	var msgEl = params.msgEl
	,	data = params.data
	,	form = params.form
	,	url = params.url;
	if(msgEl && typeof(msgEl) === 'string')	// it is just ID
		msgEl = $('#'+ msgEl);
	if(msgEl)
		msgEl.removeClass('bg-danger').removeClass('bg-success').addClass('waiting').html('');
	if(!data && form)
		data = $(form).serialize();
	if(!url && form)
		url = $(form).attr('action');
	if(form) {
		$(form).find('[name]').removeClass('bg-danger');
		$(form).find('.input-error').remove();
	}
	if(!data)
		data = {};
	if(typeof(data) === 'string')
		data += '&reqType=ajax';
	else
		data['reqType'] = 'ajax';
	$.ajax({
		url: url,
		data: data,
		type: 'POST',
		dataType: 'json',
		success: function(res) {
			if(msgEl)
				msgEl.removeClass('waiting');
			if(res.errors) {
				if(res.errors.length) {
					if(msgEl) {
						msgEl.addClass('bg-danger');
						msgEl.html( res.errors.join('<br />') );
					}
				} else if(form) {
					for(var key in res.errors) {
						$('<span class="bg-danger input-error">'+ res.errors[key]+ '</span>').insertAfter( $(form).find('[name='+ key+ ']').addClass('bg-danger') );
					}
				}
				if(typeof(params.onError) === 'function') {
					params.onError(res);
				}
			} else {
				if(msgEl)
					msgEl.addClass('bg-success');
				if(res.msg && msgEl)
					msgEl.html( res.msg.join('<br />') );
				if(typeof(params.onSuccess) === 'function') {
					params.onSuccess(res);
				}
				if(res['return']) {
					window.location.href = res['return'];
				}
			}
		}
	});
}
/**
 * Retrive from GET params query
 */
function getSearchParam(key) {
	this.pars, this.parsed;
	if(!this.parsed) {
		var tmp = window.location.search.substr(1).split('&');
		var tmp1 = new Array();
		this.pars = new Array();
		for (var i in tmp) {
			tmp1 = tmp[i].split('=');
			this.pars[tmp1[0]] = unescape(tmp1[1]);
		}
		this.parsed = true;
	}
	if(typeof(key) !== 'undefined') {
		if(this.pars && this.pars[key])
			return this.pars[key];
		else
			return false;
	} else
		return this.pars;
}
function getReqUrl(string, ext) {
	var url = urlRoot+ '/'+ string;
	if(ext && ext != '') {
		url += '.'+ ext;
	}
	return url;
}
function getAdminReqUrl(string, ext) {
	return getReqUrl(adminAlias+ '/'+ string, ext);
}
function lang(key) {
	return typeof(langData[ key ]) !== 'undefined' ? langData[ key ] : key;
}
function createTextEditor(name) {
	CKEDITOR.replace(name, {
		language: 'en-gb',
		uiColor: '#d8d8d8'
	});
}
function textEditorsSave() {
	$('textarea.ckeditor').each(function () {
		var name = $(this).attr('name');
		if(CKEDITOR && CKEDITOR.instances && CKEDITOR.instances[ name ]) {
			$(this).val(CKEDITOR.instances[ name ].getData());
		}
	});
}
function redirect(url) {
    document.location.href = url;
}
function reload() {
    document.location.reload();
}