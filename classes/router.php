<?php
class router {
	private $_requestUri = '';
	private $_baseParts = array();
	private $_parts = array();
	private $_isAdmin = false;
	private $_isAjax = false;
	private $_alias = false;
	private $_reqExt = '';
	
	static public function getInstance() {
		static $instance;
		if(!$instance) {
			$instance = new router();
		}
		return $instance;
	}
	static public function _() {
		return self::getInstance();
	}
	public function init() {
		$this->_requestUri = str_replace(array($_SERVER['QUERY_STRING'], '?'), '', $_SERVER['REQUEST_URI']);
		if(strpos($this->_requestUri, '/') === 0) {
			$this->_requestUri = substr($this->_requestUri, 1);
		}
		if(!empty($this->_requestUri)) {
			if(strpos($this->_requestUri, '.')) {
				$reqUriExt = explode('.', $this->_requestUri);
				$this->_requestUri = $reqUriExt[0];
				$this->_reqExt = strtolower($reqUriExt[1]);
			}
			$this->_baseParts = explode('/', $this->_requestUri);
			foreach($this->_baseParts as $i => $p) {
				$part = trim($p);
				if(empty($part)) continue;
				if(!$i && $part == ADMIN_ALIAS) {
					$this->_isAdmin = true;
					continue;
				}
				$this->_parts[] = $part;
			}
		}
		$this->_isAjax = req::getVar('reqType') == 'ajax' || $this->_reqExt == 'ajax';
	}
	public function isAdmin() {
		return $this->_isAdmin;
	}
	public function getParts() {
		return $this->_parts;
	}
	public function getPart($i) {
		return isset($this->_parts[ $i ]) ? $this->_parts[ $i ] : false;
	}
	public function isAjax() {
		return $this->_isAjax;
	}
	public function getCurrentAlias() {
		if($this->_alias === false) {	// It can be just empty
			$this->_alias = implode('/', $this->_parts);
		}
		return $this->_alias;
	}
}