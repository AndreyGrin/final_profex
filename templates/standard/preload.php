<?php
/**
 * Preload any required scripts, styles or other data for template
 */
document::_()->addCoreScript('jquery.min');
document::_()->addCoreScript('core');
document::_()->addJsVar('g_isLoggedIn', frame::_()->getModule('user')->isLoggedIn());
document::_()->connectJqueryUi();
frame::_()->getModule('user')->loadFrontendAssets();
//document::_()->addScript('script', document::_()->getTemplatesUrl(). '/js/script.js');
//document::_()->addStyle('style', document::_()->getTemplatesUrl(). '/css/style.css');

// login page
if(frame::_()->isLogin()){
    document::_()->addStyle('cloud-admin.min');
    document::_()->addStyle('font-awasome', URL_ROOT.'/css/font-awesome/css/font-awesome.min.css');
    document::_()->addStyle('open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=latin,cyrillic');
}

// admin includes
if(router::_()->isAdmin()){
    document::_()->addStyle('cloud-admin.min');
    document::_()->addStyle('bootstrap.min');
    document::_()->addStyle('font-awasome', URL_ROOT.'/css/font-awesome/css/font-awesome.min.css');
    document::_()->addStyle('open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=latin,cyrillic');
    document::_()->addStyle('admin');
    document::_()->addStyle('responsive.min');
    document::_()->addStyle('skin', URL_ROOT.'/css/themes/night.min.css');
    
    document::_()->addScript('bootstrap.min');
    document::_()->addScript('script');
    document::_()->addScript('jquery.cookie.min');
    document::_()->addScript('ckeditor', URL_ROOT.'/js/ckeditor/ckeditor.js');
    document::_()->addScript('admin');
}

// frontend inludes
if(!router::_()->isAdmin() && !frame::_()->isLogin()){
    document::_()->addStyle('bootstrap.min');
    document::_()->addStyle('animate');
    document::_()->addStyle('frontend/bootflat.min');
    document::_()->addStyle('frontend/jquery.bxslider');
    document::_()->addStyle('font-awasome', URL_ROOT.'/css/font-awesome/css/font-awesome.min.css');
    //document::_()->addStyle('style', document::_()->getTemplatesUrl(). '/style.less');
    
    document::_()->addScript('bootstrap.min');
    document::_()->addScript('animationEngine');
    document::_()->addScript('frontend/jquery.bxslider.min');
    document::_()->addScript('frontend/less-1.7.5.min');
    document::_()->addScript('frontend/theme');
    document::_()->addScript('jquery.animateNumber.min');
}

if(frame::_()->isHome()) {
	//document::_()->addScript('frontend.products', frame::_()->getModule('products')->getUrl(). '/js/frontend.products.js');
}

/**
 * router::_()->isAdmin();
 * router::_()->isAjax();
 */

document::_()->addJsVar('urlRoot', URL_ROOT);
document::_()->addJsVar('adminAlias', ADMIN_ALIAS);
document::_()->addJsVar('langData', lang::getAllData());
