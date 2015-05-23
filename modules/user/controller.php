<?php
class userController extends controller {
	public function loginAction() {
		$login = req::getVar('login');
		$passwd = req::getVar('passwd');
		if($this->getModel()->login($login, $passwd)) {
			$this->pushMessage(lang::_('WELCOME_LOGIN'));
			$return = req::getVar('return');
			if(empty($return))
				$return = URL_ROOT;
			if($return && strpos($return, URL_ROOT) === 0)	// Don't redirect to other sites after login
				$this->addData('return', $return);
		} else
			$this->pushError ($this->getModel()->getErrors());
	}
	public function subscribeAction() {
		$newUser = true;
		if(!html::formValid('subscribe')) {
			$this->pushError (lang::_('INVALID_FORM_DATA'));
			return;
		}
		$data = req::get('post');
		if(empty($data)) {
			$newUser = false;
		}
		if(!isset($data['pid'])) {
			$data['pid'] = (int) router::_()->getPart(2);
		}
		if(($id = $this->getModel()->subscribe( $data ))) {
			if($newUser) {
				$this->getModel()->setLoggedIn( $this->getModel()->getById($id) );
			}
			$this->getModel()->updateCurrentSubscribedList();
			$this->pushMessage(lang::_('WELCOME_SUBSCRIBED'));
		} else
			$this->pushError ($this->getModel()->getErrors());
	}
	public function logoutAction() {
		if($this->getModel()->logout()) {
			// Do nothing for now
		} else
			$this->pushError ($this->getModel()->getErrors());
		redirect(uri::getLink());
	}
	public function getSubscribeFormAction() {
		$this->addData('html', $this->getView()->getSubscribeForm());
	}
	public function listAction() {
		document::_()->addScript('admin.user.list', $this->getModule()->getUrl(). '/js/admin.user.list.js');
		document::_()->setContent( 
			$this->getView()->getAdminList( 
				$this->getModel()->getList() 
			) 
		);
	}
	public function removeAction() {
		$id = (int) router::_()->getPart(2);
		if($id) {
			if($this->getModel()->removeById($id)) {
				$this->addData('id', $id);
			} else
				$this->pushError ($this->getModel()->getErrors());
		} else
			$this->pushError (lang::_('INVALID_ID'));
	}
	public function saveAction() {
		if(($id = $this->getModel()->saveEdit(req::get('post')))) {
			$this->addData('program', $this->getModel()->getById($id));
			if($this->getModel()->getLastDbAction() == 'INSERT') {	// For new added - redirect user to edit URL
				$this->addData('program_edit_link', $this->getModule()->getEditLink($id));
			}
			$this->pushMessage(lang::_('SAVED'));
		} else
			$this->pushError ($this->getModel()->getErrors());
	}
	public function profileAction() {
		$user = $this->getModel()->getLoggedIn();
		if($user) {
			document::_()->addScript('frontend.user.profile', $this->getModule()->getUrl(). '/js/frontend.user.profile.js');
			document::_()->setContent( 
				$this->getView()->getProfileContent( $user ) 
			);
		}
	}
	public function saveProfileAction() {
		$user = $this->getModel()->getLoggedIn();
		if($user && $this->getModel()->saveProfile(req::get('post'))) {
			$this->pushMessage(lang::_('SAVED'));
		} else
			$this->pushError ($this->getModel()->getErrors());
	}
	public function unsubscribeAction() {
		
		$pid = (int) router::_()->getPart(2);
		if($pid) {
			$user = $this->getModel()->getLoggedIn();
			if($user && $this->getModel()->unsubscribe($user['id'], $pid)) {
				$this->pushMessage(lang::_('UNSUBSCRIBED'));
			} else
				$this->pushError ($this->getModel()->getErrors());
		} else
			$this->pushError (lang::_('INVALID_ID'));
	}
	public function getPermissions() {
		return array(
			ADMIN => array('list', 'remove', 'save'),
			SUBSCRIBER => array('profile', 'saveProfile', 'unsubscribe'),
		);
	}
}