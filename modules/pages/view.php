<?php
class pagesView extends view {
	public function getLoginPage($return = '') {
		$this->assign('return', $return);
		return parent::getContent('loginPage');
	}
}