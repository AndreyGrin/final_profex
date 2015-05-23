<?php
class mailView extends view {
	public function getAdminList($dataList) {
		$this->assign('dataList', $dataList);
		$this->assign('fieldsList', $this->getListFields());
		$this->assign('module', $this->getModule());
		return parent::getContent('admin.list');
	}
	public function getListFields() {
		$baseFields = $this->getModel()->getFields();
		unset($baseFields['content']);
		return array_merge($baseFields, array(
			'date_created' => array('label' => lang::_('DATE_CREATED')),
			'actions' => array('label' => lang::_('ACTIONS')),
		));
	}
}