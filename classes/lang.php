<?php
class lang {
	static private $_allData = array();
	static public function init() {
		$langFilePath = DIR_LANG. DS. LANG. '.ini';
		if(file_exists($langFilePath)) {
			self::$_allData = parse_ini_file($langFilePath);
		} else
			throw new Exception('Can\'t find lang file!!!');
	}
	static public function _($key) {
		return isset(self::$_allData[ $key ]) ? self::$_allData[ $key ] : $key;
	}
	static public function _e($key) {
		echo self::_($key);
	}
	static public function getAllData() {
		return self::$_allData;
	}
}