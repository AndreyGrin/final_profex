<?php
class help_typesModel extends modelSimple {
	public function __construct($code) {
		parent::__construct($code);
		$this->_setFields(array(
			'label' => array('valid' => 'notEmpty', 'label' => lang::_('HELP_TYPE_LABEL')),
		));
		$this->_setTbl('help_types');
	}
	public function getListForFrontend($conditions = array(), $full = false, $sortOrder = '') {
		return $this->getList($conditions, $full);
	}
}