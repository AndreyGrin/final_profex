<?php
class categoriesModel extends modelSimple {
	public function __construct($code) {
		parent::__construct($code);
		$this->_setFields(array(
			'label' => array('valid' => 'notEmpty', 'label' => lang::_('CATEGORY_LABEL')),
			'parent_id' => array('label' => lang::_('CATEGORY_PARENT')),
		));
		$this->_setTbl('categories');
	}
	public function getListForFrontend($conditions = array(), $full = false, $sortOrder = '') {
		return $this->getList($conditions, $full);
	}
}