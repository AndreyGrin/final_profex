<?php
	/*Base constants*/
	define('DS', DIRECTORY_SEPARATOR);
	define('TEST_MODE', true);
	define('DB_LOG', false);
	define('MAIL_LOG', true);		// Should be true for this task - as mail server didn't worked for me here
	define('DEFAULT_FRONTEND_ACTION', 'programs::list');
	define('DEFAULT_ADMIN_ACTION', 'dashboard::index');
	define('ADMIN_ALIAS', 'administrator');
	define('LOGIN_ALIAS', 'login');
	define('UPLOADS', 'uploads');
	define('LANG', 'ua');
	/*Database settings*/
	define('DB_HOST', 'localhost');
	define('DB_USER', 'uwc');
	define('DB_PASSWD', '6cQpFb3c');
	define('DB_NAME', 'uwc');
	/*Base filesystem path*/
	define('DIR_ROOT', dirname(__FILE__));
	define('DIR_CLASSES', DIR_ROOT. DS. 'classes');
	define('DIR_MODULES', DIR_ROOT. DS. 'modules');
	define('DIR_TEMPLATE', DIR_ROOT. DS. 'templates');
	define('DIR_JS', DIR_ROOT. DS. 'js');
	define('DIR_CSS', DIR_ROOT. DS. 'css');
	define('DIR_LANG', DIR_ROOT. DS. 'lang');
	define('DIR_LOG', DIR_ROOT. DS. 'log');
	define('DIR_INSTALL', DIR_ROOT. DS. 'install');
	/*Base URLs*/
	define('PROTOCOL', (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://'));
	define('HOST', $_SERVER['HTTP_HOST']);
	define('URL_ROOT', PROTOCOL. HOST);
	define('URL_JS', URL_ROOT. '/js');
	define('URL_CSS', URL_ROOT. '/css');
	define('URL_MODULES', URL_ROOT. '/modules');
	define('URL_TEMPLATES', URL_ROOT. '/templates');
	/*Additional constants*/
	define('ONE', 'one');
	define('ROW', 'row');
	define('COL', 'col');
	define('ALL', 'all');
	define('STANDARD', 'standard');
	define('RAW_POST_DATA', 'php://input');
	/*Module types*/
	define('USUAL', 'usual');
	define('WIDGET', 'widget');
	/*User roles code - @see roles db table*/
	define('SUBSCRIBER', 'subscriber');
	define('ADMIN', 'admin');
	/*Really secret:)*/
	define('SECRET_HASH', 'kR#(#3I(F#)R3RO#_RF##RPor3p%$#$R)3RFKLEWPFK#)RFkfkf95');
	if(TEST_MODE) {
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}