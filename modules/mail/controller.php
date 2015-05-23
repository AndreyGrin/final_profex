<?php
class mailController extends controller {
	public function listAction() {
		document::_()->addScript('admin.mail.list', $this->getModule()->getUrl(). '/js/admin.mail.list.js');
		document::_()->setContent( 
			$this->getView()->getAdminList( 
				$this->getModel()->getList(array('FIELDS' => array('id', 'to_address', 'subject', 'date_created', 'res'))) 
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
	public function viewAction() {
		$id = (int) router::_()->getPart(2);
		if($id && ($product = $this->getModel()->getById($id, true))) {
			document::_()->setTitle($product['label']);
			$this->getModel()->setViewed($id, frame::_()->getModule('clients')->getCurrentId());
			document::_()->addScript('frontend.programs', $this->getModule()->getUrl(). '/js/frontend.programs.js');
			document::_()->setContent( 
				$this->getView()->getSingle( 
					$product
				) 
			);
		} else {
			frame::_()->set404( true );
		}
	}
	public function getContentAction() {
		$id = (int) router::_()->getPart(2);
		if($id) {
			if(($mail = $this->getModel()->getById($id))) {
				$this->addData('content', $mail['content']);
			} else
				$this->pushError ($this->getModel()->getErrors());
		} else
			$this->pushError (lang::_('INVALID_ID'));
	}
	public function getPermissions() {
		return array(
			ADMIN => array('remove', 'list', 'view', 'getContent'),
		);
	}
}