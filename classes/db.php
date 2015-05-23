<?php
class db {
	protected $_host = '', $_user = '', $_pass = '', $_dbName = '';
	protected $_link = NULL;
	protected $_query = '';
	protected $_queries = array();
	static public function getInstance($host = '', $user = '', $pass = '', $dbName = '') {
		static $instance;
		if(!$instance) {
			$instance = new db($host, $user, $pass, $dbName);
		}
		return $instance;
	}
	static public function _($host = '', $user = '', $pass = '', $dbName = '') {
		return self::getInstance($host, $user, $pass, $dbName);
	}
	public function __construct($host = '', $user = '', $pass = '', $dbName = '') {
		list($this->_host, $this->_user, $this->_pass, $this->_dbName) = array($host, $user, $pass, $dbName);
		
		if(!($this->_link = mysql_connect($this->_host, $this->_user, $this->_pass))) {
			throw new Exception('Unuanable to connect to database!!!');
		}
		if(!mysql_select_db($this->_dbName, $this->_link)) {
			throw new Exception('Unuanable to select to database!!!');
		}
	}
	public function get($query, $return = ALL, $where = '', $delim = 'AND') {
		$data = false;
		if(!empty($where)) {
			$query .= ' WHERE '. $this->toQuery($where, $delim);
		}
		switch($return) {
			case ONE:
				$data = $this->fetchOne($query);
				break;
			case ROW:
				$data = $this->fetchAssocFirst($query);
				break;
			case COL:
				$data = $this->fetchCol($query);
				break;
			case ALL:
				$data = $this->fetchAssoc($query);
				break;
		}
		return $data;
	}
	public function getLastId() {
		return mysql_insert_id($this->_link);
	}
	public function query($query) {
		$this->_query = $query;
		if(DB_LOG)
			$start = microtime (true);
		$res = mysql_query($this->_query, $this->_link);
		if(DB_LOG) {
			$this->_queries[] = array(
				'query' => $this->_query,
				'time' => (microtime(true) - $start),
				'success' => $res ? true : false
			);
		}
		if(TEST_MODE && ($error = $this->getLastError())) {
			throw new Exception('MySql Error: ['. $error. ']');
		}
		return $res;
	}
	public function getQueries() {
		return $this->_queries;
	}
	public function getLastQuery() {
		return $this->_query;
	}
	public function fetchCol($query) {
		$data = array();
		$dbRes = $this->query($query);
		if($dbRes) {
			while($row = mysql_fetch_row($dbRes)) $data[] = $row[0];
			return $data;
		}
		return false;
	}
	public function fetchAssoc($query) {
		$data = array();
		$dbRes = $this->query($query);
		if($dbRes) {
			while($row = mysql_fetch_assoc($dbRes)) $data[] = $row;
			return $data;
		}
		return false;
	}
	public function fetchAssocFirst($query) {
		$dbRes = $this->query($query);
		if($dbRes) {
			return mysql_fetch_assoc($dbRes);
		}
		return false;
	}
	public function fetchOne($query) {
		$dbRes = $this->query($query);
		if($dbRes) {
			$row = mysql_fetch_row($dbRes);
			return $row[0];
		}
		return false;
	}
	public function toName($name) {
		return '`'. $name. '`';
	}
	public function toQuery($data, $delim) {
		$resStr = '';
		if(is_array($data)) {
			if(!empty($data)) {
				$queryArr = array();
				$keyValDelimiters = array('=', '!=', '>', '<', '>=', '<=', 'LIKE', 'WHOLE_LIKE', 'IN');
				$sqlDelimiters = array('AND', 'OR');
				foreach($data as $key => $val) {
					if(in_array($key, $keyValDelimiters)) {	// Data provided by delimiter
						foreach($val as $keySub => $valSub) {
							if($key == 'WHOLE_LIKE') {
								$queryArr[] = 'LOWER('. $keySub. ') LIKE LOWER("%'. $this->escape($valSub). '%")';
							} elseif($key == 'IN') {
								$queryArr[] = $keySub. ' IN ("'. (is_array($valSub) ? implode('","', $valSub) : $valSub). '")';
							} else
								$queryArr[] = $keySub. $key. '"'. $this->escape($valSub). '"';
						}
					} elseif(in_array($key, $sqlDelimiters)) {
						$queryArr[] = '('. $this->toQuery( $val, $key ). ')';
					} else {
						$queryArr[] = $key. '="'. $this->escape($val). '"';
					}
				}
				$resStr = implode(' '. $delim. ' ', $queryArr);
			}
		} else
			$resStr = $data;
		return $resStr;
	}
	public function escape($data) {
		$res = NULL;
		if(is_array($data)) {
			foreach($data as $k => $v) {
				$data[ $k ] = $this->escape( $v );
			}
		} else {
			$res = mysql_real_escape_string($data, $this->_link);
		}
		return $res;
	}
	public function getLastError() {
		$lastError = mysql_error( $this->_link );
		if($lastError) {
			if(TEST_MODE)
				return $lastError. ', full query: '. $this->getLastQuery();
			else
				return lang::_('DB_ERROR');
		}
		return false;
	}
	public function arrayToDb($array) {
		return base64_encode(serialize($array));
	}
	public function arrayFromDb($string) {
		return unserialize(base64_decode($string));
	}
	public function exist($table, $column = '', $value = '') {
        if(empty($column) && empty($value)) {       //Check if table exist
			 $res = $this->get('SELECT COUNT(*) AS total
				FROM information_schema.tables
				WHERE table_schema = "'. $this->_dbName. '"
					AND table_name = "'. $table. '"
				LIMIT 1;', ONE);
        } elseif(empty($value)) {                   //Check if column exist
            $res = $this->get('SHOW COLUMNS FROM '. $table. ' LIKE "'. $column. '"', ONE);
        } else {                                    //Check if value in column table exist
            $res = $this->get('SELECT COUNT(*) AS total FROM '. $table. ' WHERE '. $column. ' = "'. $value. '"', ONE);
        }
        return !empty($res);
    }
}