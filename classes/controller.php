<?php
abstract class controller extends baseMvc {
	protected $_view = NULL;
	protected $_model = NULl;
	protected $_responce = array();
			
	public function beforeRun() {}
	public function afterRun() {}
	public function run($action) {
		if(method_exists($this, $action)) {
			$this->beforeRun();
			$this->$action();
			$this->afterRun();
		}
	}
	public function getResponce() {
		$errors = $this->getErrors();
		$msg = $this->getMessages();
		if($errors)
			$this->_responce['errors'] = $errors;
		if($msg)
			$this->_responce['msg'] = $msg;
		return $this->_responce;
	}
	public function addData($key, $val) {
		$this->_responce[ $key ] = $val;
	}
	public function getView() {
		if(!$this->_view) {
			$this->_view = $this->_createView();
		}
		return $this->_view;
	}
	public function getModel() {
		if(!$this->_model) {
			$this->_model = $this->_createModel();
		}
		return $this->_model;
	}
	protected function _createView() {
		$viewPath = $this->getModule()->getPath(). DS. 'view.php';
		if(file_exists($viewPath)) {
			require_once($viewPath);
			$viewClassName = $this->_code. 'View';
			return new $viewClassName( $this->_code );
		} else
			throw new Exception('Can\'t find view for '. $this->_code);
	}
	protected function _createModel() {
		$modelPath = $this->getModule()->getPath(). DS. 'model.php';
		if(file_exists($modelPath)) {
			require_once($modelPath);
			$modelClassName = $this->_code. 'Model';
			return new $modelClassName( $this->_code );
		} else
			throw new Exception('Can\'t find model for '. $this->_code);
	}
	/**
	 * Here we should add all admin functions, like:
	 * return array(ADMIN => array('save'));
	 */
	public function getPermissions() {
		return array();
	}
}