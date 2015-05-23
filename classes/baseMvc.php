<?php
abstract class baseMvc {
	protected $_internalErrors = array();
	protected $_internalMessages = array();
	protected $_code = '';
	
	public function __construct($code) {
		$this->_setCode( $code );
	}
	public function pushError($error, $key = '') {
		if(is_array($error)) {
			$this->_internalErrors = array_merge($this->_internalErrors, $error);
		} elseif(!empty($key)) {
			$this->_internalErrors[ $key ] = $error;
		} else {
			$this->_internalErrors[] = $error;
		}
	}
	public function pushMessage($msg, $key = '') {
		if(is_array($msg)) {
			$this->_internalMessages = array_merge($this->_internalMessages, $msg);
		} elseif(!empty($key)) {
			$this->_internalMessages[ $key ] = $msg;
		} else {
			$this->_internalMessages[] = $msg;
		}
	}
	public function getErrors() {
		return $this->_internalErrors;
	}
	public function getMessages() {
		return $this->_internalMessages;
	}
	protected function _setCode($code) {
		$this->_code = $code;
	}
	public function getCode() {
		return $this->_code;
	}
	public function getModule() {
		return frame::_()->getModule( $this->_code );
	}
	public function getModel() {
		return frame::_()->getModule( $this->_code )->getController()->getModel();
	}
	public function getView() {
		return frame::_()->getModule( $this->_code )->getController()->getView();
	}
}