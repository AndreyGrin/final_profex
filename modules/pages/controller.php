<?php
class pagesController extends controller {
	public function loginAction() {
		document::_()->addScript('pages.login', $this->getModule()->getUrl(). '/js/pages.login.js');
		document::_()->setContent( $this->getView()->getLoginPage(req::getVar('return')) );
		document::_()->setMainFile('login');
	}
}