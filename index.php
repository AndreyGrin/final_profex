<?php
/**
 * Rush-store
 * by Profex team
 */
	require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'config.php');
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'functions.php');
	
	try {
		frame::_()->init();
		frame::_()->run();
		frame::_()->display();
		logWriter::write();
	} catch(Exception $e) {
		if(TEST_MODE) {
			echo '<pre>';
			var_dump($e);
			echo '</pre>';
		} else {
			echo 'There are some problem in our server. Please contact our developers.';
		}
	}
	