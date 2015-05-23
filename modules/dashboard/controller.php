<?php
class dashboardController extends controller {
	public function indexAction() {
		document::_()->setContent( 
			$this->getView()->getIndex(array(
				'totals' => array(
					'programs' => frame::_()->getModule('programs')->getModel()->getTotal(),
					'news' => frame::_()->getModule('news')->getModel()->getTotal(),
					'subscribers' => frame::_()->getModule('user')->getModel()->getTotal(array('role_id' => 1/*Subscribers*/)),
					'donated' => frame::_()->getModule('programs')->getModel()->getTotalDonate(),
				),
			)) 
		);
	}
	public function getPermissions() {
		return array(
			ADMIN => array('index'),
		);
	}
}