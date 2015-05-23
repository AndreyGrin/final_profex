<?php
abstract class widget extends module {
	protected $_settings = array();
	public function __construct($code, $path) {
		parent::__construct($code, $path);
		$this->_setType( WIDGET );
	}
	public function loadAssets() {}
	public function visible() {	// Always for all frontend
		return !router::_()->isAdmin();
	}
	public function getContent() {
		return $this->getView()->getWidgetContent();
	}
	public function setSettings($settings) {
		$this->_settings = $settings;
	}
	public function getSettings() {
		return $this->_settings;
	}
	public function getSetting($key) {
		return isset($this->_settings[ $key ]) ? $this->_settings[ $key ] : NULL;
	}
}