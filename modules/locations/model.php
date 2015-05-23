<?php
class locationsModel extends modelSimple {
	public function __construct($code) {
		parent::__construct($code);
		$this->_setFields(array(
			'label' => array('valid' => 'notEmpty', 'label' => lang::_('LOCATION_LABEL')),
			'parent_id' => array('label' => lang::_('LOCATION_PARENT')),
		));
		$this->_setTbl('locations');
	}
	public function getListForFrontend($conditions = array(), $full = false, $sortOrder = '') {
		return $this->getList($conditions, $full);
	}
}