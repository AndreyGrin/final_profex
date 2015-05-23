<?php
class programsView extends view {
	public function getAdminList($programs) {
		$this->assign('programs', $programs);
		$this->assign('programsFieldsList', $this->getListFields());
		$this->assign('module', $this->getModule());
		return parent::getContent('admin.list');
	}
	public function getList($programs, $pageData = array()) {
		$this->assign('programs', $programs);
		$this->assign('pageData', $pageData);
		
		return parent::getContent('list');
	}
	public function getEditForm($program = array()) {
		$this->assign('program', $program);
		$this->assign('edit', !empty($program));
		$this->assign('categoriesList', rs('categories.model.getListForParentSelect'));
		$this->assign('locationsList', rs('locations.model.getListForParentSelect'));
		$this->assign('helpTypesList', rs('help_types.model.getListForSelect'));
		return parent::getContent('editForm');
	}
	public function getListFields() {
		$baseFields = $this->getModel()->getFields();
		unset($baseFields['description']);
		return array_merge($baseFields, array(
			'date_created' => array('label' => lang::_('DATE_CREATED')),
			'actions' => array('label' => lang::_('ACTIONS')),
		));
	}
	public function getSingle($program) {
		$this->assign('program', $program);
		$this->assign('donated', $this->getModel()->getDonatedUsers($program['id']));
		return parent::getContent('single');
	}
	public function getSearchForm($searched) {
		$this->assign('searched', $searched);
		return parent::getContent('searchForm');
	}
	public function showSearchForm($searched) {
		echo $this->getSearchForm($searched);
	}
}