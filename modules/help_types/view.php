<?php
class help_typesView extends view {
	public function getAdminList($dataList) {
		$this->assign('dataList', $dataList);
		$this->assign('fieldsList', $this->getListFields());
		$this->assign('module', $this->getModule());
		return parent::getContent('admin.list');
	}
	public function getEditForm($data = array()) {
		$edit = !empty($data);
		$this->assign('data', $data);
		$this->assign('edit', $edit);
		return parent::getContent('editForm');
	}
	public function getListFields() {
		$baseFields = $this->getModel()->getFields();
		return array_merge($baseFields, array(
			'actions' => array('label' => lang::_('ACTIONS')),
		));
	}
}