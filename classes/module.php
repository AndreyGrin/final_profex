<?php
abstract class module {
	protected $_code = '';
	protected $_path = '';
	protected $_url = '';
	protected $_type = USUAL;
	
	protected $_controller = NULL;
	
	public function __construct($code, $path) {
		$this->_code = $code;
		$this->_path = $path;
	}
	public function init() {}
	public function run($action) {
		$this->getController()->run( $this->convertAction($action) );
	}
	protected function convertAction($action) {
		return $action. 'Action';
	}
	public function actionExists($action) {
		return method_exists($this->getController(), $this->convertAction($action));
	}
	public function getController() {
		if(!$this->_controller) {
			$this->_controller = $this->_createController();
		}
		return $this->_controller;
	}
	protected function _createController() {
		$controllerPath = $this->_path. DS. 'controller.php';
		if(file_exists($controllerPath)) {
			require_once($controllerPath);
			$controllerClassName = $this->_code. 'Controller';
			return new $controllerClassName( $this->_code );
		} else
			throw new Exception('Can\'t find controller for '. $this->_code);
	}
	public function getModel() {
		return $this->getController()->getModel();
	}
	public function getView() {
		return $this->getController()->getView();
	}
	public function getPath() {
		return $this->_path;
	}
	public function getUrl() {
		if(empty($this->_url)) {
			$this->_url = URL_MODULES. '/'. $this->_code;
		}
		return $this->_url;
	}
	protected function _setType($newType) {
		$this->_type = $newType;
	}
	public function getType() {
		return $this->_type;
	}
}