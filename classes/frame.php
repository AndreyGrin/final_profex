<?php
class frame {
	private $_modules = array();
	
	private $_mod = '';
	private $_action = '';
	
	private $_is404 = false;
	private $_isLogin = false;
	private $_isHome = false;
	
	static public function getInstance() {
		static $instance;
		if(!$instance) {
			$instance = new frame();
		}
		return $instance;
	}
	static public function _() {
		return self::getInstance();
	}
	public function init() {
		session_start();
		db::_(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
		installer::_()->checkInstalled();
		lang::init();
		router::_()->init();
		/*Extruct modules*/
		foreach(glob(DIR_MODULES. DS. '*') as $modDir) {
			$modClassPath = $modDir. DS. 'mod.php';
			if(file_exists($modClassPath)) {
				require_once($modClassPath);
				$modName = basename($modDir);
				$modClassName = $modName. 'Mod';
				$this->_modules[ $modName ] = new $modClassName($modName, $modDir);
			}
		}
		/*If admin area and user is not logged-in - redirect to login page*/
		if(router::_()->isAdmin() && !$this->getModule('user')->isAdmin()) {
			redirect(uri::getLink(LOGIN_ALIAS, array(
				'return' => uri::getCurrent()
			)));
		}
		/*Check what module should be now triggered*/
		$routerParts = router::_()->getParts();
		
		if(!empty($routerParts)) {
			if(isset($routerParts[ 0 ]) && isset($this->_modules[ $routerParts[ 0 ] ])) {
				$this->_setMod( $routerParts[ 0 ] );
				if(isset($routerParts[ 1 ]) && $this->_modules[ $this->_mod ]->actionExists($routerParts[ 1 ])) {
					$this->_setAction( $routerParts[ 1 ] );
				} else {
					$this->_setAction( 'index' );
				}
			} elseif(isset($routerParts[ 0 ]) && $routerParts[ 0 ] == LOGIN_ALIAS) {	// Login page
				$this->_setMod( 'pages' );
				$this->_setAction( 'login' );
				$this->_isLogin = true;
			} else {
				$this->set404( true );
			}
		} else {
			if(router::_()->isAdmin() && defined('DEFAULT_ADMIN_ACTION') && DEFAULT_ADMIN_ACTION) {
				$defaultAction = DEFAULT_ADMIN_ACTION;
			} elseif(!router::_()->isAdmin() && defined('DEFAULT_FRONTEND_ACTION') && DEFAULT_FRONTEND_ACTION) {
				$defaultAction = DEFAULT_FRONTEND_ACTION;
			} else {
				$defaultAction = false;
			}
			if($defaultAction) {
				$defaultModAction = explode('::', $defaultAction);
				$this->_setMod( $defaultModAction[ 0 ] );
				$this->_setAction( $defaultModAction[ 1 ] );
			}
			$this->_isHome = true;
		}
		/*Init modules - only after extraction as in init process we can use other modules*/
		foreach($this->_modules as $mod) {
			$mod->init();
		}
	}
	public function run() {
		if($this->_mod && $this->_action) {
			if($this->_checkPermissions($this->_mod, $this->_action)) {
				$this->getModule( $this->_mod )->run( $this->_action );
				if(router::_()->isAjax()) {
					$responce = $this->getModule( $this->_mod )->getController()->getResponce();
					exit(json_encode($responce));
				}
			} else {
				$msg = 'You have no permissions to see this page. Please do not try to cheat my system!';
				if(router::_()->isAjax()) {
					$msg = json_encode(array('errors' => array($msg)));
				}
				exit($msg);
			}
		}
	}
	private function _checkPermissions($mod, $action) {
		$action = trim(strtolower($action));
		$permMethods = $this->getModule( $mod )->getController()->getPermissions();
		if(!empty($permMethods)) {
			foreach($permMethods as $permission => $methods) {
				$preparedMethods = array_map('strtolower', $methods);
				if($permission == ADMIN && in_array($action, $preparedMethods) && !$this->getModule('user')->isAdmin()) {
					return false;
				}
			}
		}
		return true;
	}
	public function display() {
		document::_()->display();
	}
	public function getModule($code) {
		return (isset($this->_modules[$code]) ? $this->_modules[$code] : false);
	}
	public function getModulesList($type = '') {
		if(empty($type))
			return $this->_modules;
		else {
			$res = array();
			foreach($this->_modules as $key => $mod) {
				if($mod->getType() == $type)
					$res[ $key ] = $mod;
			}
			return $res;
		}
	}
	private function _setMod($mod) {
		$this->_mod = $mod;
	}
	private function _setAction($action) {
		$this->_action = $action;
	}
	public function is404() {
		return $this->_is404;
	}
	public function set404($newVal) {
		$this->_is404 = $newVal;
	}
	public function isLogin() {
		return $this->_isLogin;
	}
	public function isHome() {
		return $this->_isHome;
	}
}
