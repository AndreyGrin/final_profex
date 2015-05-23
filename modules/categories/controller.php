<?php
class categoriesController extends controller {
	public function listAction() {
		if(router::_()->isAdmin()) {
			document::_()->addScript('admin.categories.list', $this->getModule()->getUrl(). '/js/admin.categories.list.js');
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
		document::_()->setTitle(lang::_('ADD_CATEGORY'));
		document::_()->addScript('admin.categories.edit', $this->getModule()->getUrl(). '/js/admin.categories.edit.js');
		document::_()->setContent( $this->getView()->getEditForm() );
	}
	public function editAction() {
		$id = (int) router::_()->getPart(2);
		$data = $this->getModel()->getById($id, true);
		document::_()->setTitle(lang::_('EDIT_CATEGORY'). ' '. $data['label']);
		document::_()->addScript('admin.categories.edit', $this->getModule()->getUrl(). '/js/admin.categories.edit.js');
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
	public function addImageAction() {
		$fileData = frame::_()->getModule('files')->getModel()->saveFileFromRequest();
		if($fileData) {
			$pid = (int) router::_()->getPart(2);
			if($pid) {
				$this->getModel()->bindFiles($pid, $fileData['id']);
			}
			$this->addData('file', $this->getModel()->prepareFileData($fileData));
			$this->pushMessage(lang::_('SAVED'));
		} else
			$this->pushError (frame::_()->getModule('files')->getModel()->getErrors());
	}
	public function removeImageAction() {
		$pid = (int) router::_()->getPart(2);
		$fid = (int) router::_()->getPart(3);
		if($pid && $fid) {
			if($this->getModel()->unbindFile($pid, $fid)) {
				$this->pushMessage(lang::_('DONE'));
				$this->addData('fid', $fid);
			} else
				$this->pushError($this->getModel()->getErrors());
		} else
			$this->pushError (lang::_('INVALID_ID'));
	}
	/*public function viewAction() {
		$id = (int) router::_()->getPart(2);
		if($id && ($category = $this->getModel()->getById($id))) {
			document::_()->setTitle($category['label']);
			document::_()->addScript('frontend.programs', $this->getModule()->getUrl(). '/js/frontend.programs.js');
			document::_()->setContent( 
				$this->getView()->getSingle( 
					$product
				) 
			);
		} else {
			frame::_()->set404( true );
		}
	}*/
	public function getPermissions() {
		return array(
			ADMIN => array('save', 'remove', 'addImage', 'removeImage'),
		);
	}
}