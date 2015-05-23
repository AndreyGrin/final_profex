var g_news2progr = {};
function programRemoveClick(link) {
	if(confirm(lang('CONFIRM_REMOVE_PROGRAM'))) {
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
function newsRemoveClick(link) {
	if(confirm(lang('CONFIRM_REMOVE_NEWS'))) {
		var msgEl = $(link).parents('td:first').find('.removeMsg');
		if(!msgEl.size()) {
			msgEl = $('<span class="removeMsg" />').insertAfter(link);
		}
		doAjaxReq({
			url: $(link).attr('href')
		,	msgEl: msgEl
		,	onSuccess: function(res) {
				if(!res.errors) {
					// Let's clear it on client side too - without refresh server request
					var pid = jQuery(link).data('pid')
					,	id = jQuery(link).data('id');
					if(pid && g_news2progr[ pid ] && g_news2progr[ pid ].length && id) {
						for(var i = 0; i < g_news2progr[ pid ].length; i++) {
							if(g_news2progr[ pid ][i].id == id) {
								g_news2progr[ pid ].splice(i, 1);
								break;
							}
						}
					}
					$(link).parents('tr:first').slideDown(300, function(){
						$(this).remove();
					});
				}
			}
		});
	}
}
jQuery(document).ready(function(){
	initNewsDialog();
});
function initNewsDialog() {
	var $container = jQuery('#newsWnd').dialog({
		modal:    true
	,	autoOpen: false
	,	width: 460
	,	height: 400
	});
	jQuery('.progrNewsListBtn').click(function(){
		var pid = parseInt(jQuery(this).data('pid'));
		jQuery('#newsWndLoader').show();
		jQuery('#newsList').hide();
		jQuery('#addNewsBtn').attr('href', getAdminReqUrl('news/add/'+ pid));
		$container.dialog('open');
		if(g_news2progr[ pid ]) {
			drawNewsListClb( g_news2progr[ pid ] );
		} else {
			refreshNewsList( pid );
		}
		return false;
	});
}
function refreshNewsList(pid) {
	doAjaxReq({
		url: getAdminReqUrl('news/getListForProgr/'+ pid)
	,	onSuccess: function(res) {
			if(!res.errors) {
				g_news2progr[ pid ] = res.list;
				drawNewsListClb( g_news2progr[ pid ] );
			}
		}
	});
}
function drawNewsListClb(list) {
	var newsTbl = jQuery('#newsList')
	,	rowExample = jQuery('#newsListExampleRow');
	newsTbl.find('tr:not(#newsListExampleRow)').remove();
	if(list && list.length) {
		for(var i = 0; i < list.length; i++) {
			var newRow = rowExample.clone();
			newRow.find('.newsLabel').html( list[i].label );
			newRow.find('.newsAdded').html( list[i].date_created );
			newRow.find('.newsEditLink').attr('href', getAdminReqUrl('news/edit/'+ list[i].id));
			newRow.find('.newsRemoveLink').attr('href', getAdminReqUrl('news/remove/'+ list[i].id)).data('id', list[i].id).data('pid', list[i].pid);
			newRow.removeAttr('id').appendTo( newsTbl ).show();
		}
	}
	jQuery('#newsWndLoader').hide();
	jQuery('#newsList').show();
}
