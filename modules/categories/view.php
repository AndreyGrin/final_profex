<?php
class categoriesView extends view {
	public function getAdminList($categories) {
		$this->assign('categories', $categories);
		$this->assign('categoriesFieldsList', $this->getListFields());
		$this->assign('module', $this->getModule());
		return parent::getContent('admin.list');
	}
	public function getEditForm($data = array()) {
		$edit = !empty($data);
		$this->assign('parentsList', $this->getModel()->getListForParentSelect(array('id' => $edit ? $data['id'] : false, 'includeNone' => true)));
		$this->assign('category', $data);
		$this->assign('edit', $edit);
		return parent::getContent('editForm');
	}
	public function getListFields() {
		$baseFields = $this->getModel()->getFields();
		return array_merge($baseFields, array(
			'date_created' => array('label' => lang::_('DATE_CREATED')),
			'actions' => array('label' => lang::_('ACTIONS')),
		));
	}
}