<?php
class installer {
	private $_installed = false;
	
	static public function getInstance() {
		static $instance;
		if(!$instance) {
			$instance = new installer();
		}
		return $instance;
	}
	static public function _() {
		return self::getInstance();
	}
	public function checkInstalled() {
		$this->_installed = db::_()->exist('users');
		if($this->_installed)
			$this->_installed = (int) db::_()->get('SELECT COUNT(*) AS total FROM `users`', ONE);
		if(!$this->_installed) {
			$this->_drop();
			$this->_install();
			$this->_installed = true;
		}
		return $this->_installed;
	}
	private function _drop() {
		$allTables = db::_()->get('SHOW TABLES', COL);
		if(!empty($allTables)) {
			foreach($allTables as $tbl) {
				db::_()->query("DROP TABLE IF EXISTS $tbl");
			}
		}
	}
	private function _install() {
		// We will just use phpmyadmin dump for now
		$filePath = DIR_INSTALL. DS. 'uwc.sql';
		$installContent = array_filter(array_map('trim', explode(PHP_EOL, file_get_contents($filePath))));
		
		$queryParts = array();
		$queriesStart = array('CREATE TABLE', 'INSERT INTO');
		$queriesIgnore = array('--', '/*', 'SET SQL_MODE', 'SET time_zone');
		foreach($installContent as $line) {
			$ignore = false;
			foreach($queriesIgnore as $ignoreStr) {
				if(strpos($line, $ignoreStr) === 0) {
					$ignore = true;
					break;
				}
			}
			if($ignore) continue;
			foreach($queriesStart as $canStartStr) {
				if(strpos($line, $canStartStr) !== false) {
					if(!empty($queryParts)) {
						$this->_execInstallQuery($queryParts);
					}
					$queryParts = array();
				}
			}
			$queryParts[] = $line;
		}
		if(!empty($queryParts)) {
			$this->_execInstallQuery( $queryParts );
		}
		/*$command = "mysql -u ". DB_USER. " --password='". DB_PASSWD. "' --host='". DB_HOST. "' ". DB_NAME. " < $filePath";
		exec($command);*/
	}
	private function _execInstallQuery($queryParts) {
		db::_()->query(implode(PHP_EOL, $queryParts));
	}
}