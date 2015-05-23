<?php
class pagesMod extends module {
	private $_adminMenuList = array();
	public function isLogin() {
		$parts = router::_()->getParts();
		return (count($parts) == 1 && $parts[0] == LOGIN_ALIAS);
	}
	public function getAdminMenuList() {
		if(empty($this->_adminMenuList)) {
			$this->_adminMenuList = array(
				'dashboard' => array('label' => lang::_('DASHBOARD'), 'alias' => 'dashboard', 'icon' => '<i class="fa fa-dashboard"></i>'),
				'help_types' => array('label' => lang::_('HELP_TYPES'), 'alias' => 'help_types/list', 'icon' => '<i class="fa fa-question-circle"></i>', 'children' => array(
					'add_help_type' => array('label' => lang::_('ADD_HELP_TYPE'), 'alias' => 'help_types/add')
				)),
				'locations' => array('label' => lang::_('LOCATIONS'), 'alias' => 'locations/list', 'icon' => '<i class="fa fa-map-marker "></i>', 'children' => array(
					'add_location' => array('label' => lang::_('ADD_LOCATION'), 'alias' => 'locations/add')
				)),
				'categories' => array('label' => lang::_('CATEGORIES'), 'alias' => 'categories/list', 'icon' => '<i class="fa fa-th-list"></i>', 'children' => array(
					'add_category' => array('label' => lang::_('ADD_CATEGORY'), 'alias' => 'categories/add')
				)),
				'programs' => array('label' => lang::_('PROGRAMS'), 'alias' => 'programs/list', 'icon' => '<i class="fa fa-file-text-o"></i>', 'children' => array(
					'add_program' => array('label' => lang::_('ADD_PROGRAM'), 'alias' => 'programs/add')
				)),
				'users' => array('label' => lang::_('USERS'), 'alias' => 'user/list', 'icon' => '<i class="fa fa-users"></i>'),
				'mail_log' => array('label' => lang::_('MAIL_LOG'), 'alias' => 'mail/list', 'icon' => '<i class="fa fa-envelope-o"></i>'),
			);
			$this->_prepareAdminMenus( $this->_adminMenuList, router::_()->getCurrentAlias() );
		}
		return $this->_adminMenuList;
	}
	/**
	 * Compute URL by alias for each link
	 * @param array $menus Ref for menus array, & - is to avoid copy menus list and decrease memory spend
	 */
	private function _prepareAdminMenus(&$menus, $currentAlias) {
		foreach($menus as $i => $m) {
			if(isset($menus[ $i ]['alias'])) {
				$menus[ $i ]['url'] = uri::getAdminLink($menus[ $i ]['alias']);
				if($menus[ $i ]['alias'] == $currentAlias) {
					$menus[ $i ]['selected'] = true;
				}
			}
			if(isset($menus[ $i ]['children']) && $menus[ $i ]['children']) {
				$this->_prepareAdminMenus($menus[ $i ]['children'], $currentAlias);
			}
		}
	}
}