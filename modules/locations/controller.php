<?php
class locationsController extends controller {
	public function listAction() {
		if(router::_()->isAdmin()) {
			document::_()->addScript('admin.locations.list', $this->getModule()->getUrl(). '/js/admin.locations.list.js');
			document::_()->setContent( 
				$this->getView()->getAdminList( 
					$this->getModel()->getList() 
				) 
			);
		} else {
			document::_()->setContent( 
				$this->getView()->getList( 
					$this->getModel()->getListForFrontend(array(), true) 
				) 
			);
		}
	}
	public function addAction() {
		document::_()->setTitle(lang::_('ADD_LOCATION'));
		document::_()->addScript('admin.locations.edit', $this->getModule()->getUrl(). '/js/admin.locations.edit.js');
		document::_()->setContent( $this->getView()->getEditForm() );
	}
	public function editAction() {
		$id = (int) router::_()->getPart(2);
		$data = $this->getModel()->getById($id, true);
		document::_()->setTitle(lang::_('EDIT_LOCATION'). ' '. $data['label']);
		document::_()->addScript('admin.locations.edit', $this->getModule()->getUrl(). '/js/admin.locations.edit.js');
		document::_()->setContent( 
			$this->getView()->getEditForm(
				$data
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
		if(($id = $this->getModel()->save(req::get('post')))) {
			if($this->getModel()->getLastDbAction() == 'INSERT') {	// For new added - redirect user to edit URL
				$this->addData('edit_link', $this->getModule()->getEditLink($id));
			}
			$this->pushMessage(lang::_('SAVED'));
		} else
			$this->pushError ($this->getModel()->getErrors());
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
	public function getPermissions() {
		return array(
			ADMIN => array('save', 'remove'),
		);
	}
}