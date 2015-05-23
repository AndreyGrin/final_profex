<?php
class newsController extends controller {
	public function listAction() {
		if(router::_()->isAdmin()) {
			/*document::_()->addScript('admin.locations.list', $this->getModule()->getUrl(). '/js/admin.locations.list.js');
			document::_()->setContent( 
				$this->getView()->getAdminList( 
					$this->getModel()->getList() 
				) 
			);*/
		} else {
			document::_()->setContent( 
				$this->getView()->getList( 
					$this->getModel()->getListForFrontend(array(), true) 
				) 
			);
		}
	}
	public function getListForProgrAction() {
		$pid = (int) router::_()->getPart(2);
		$this->addData('list', $this->getModel()->getListForProgr($pid, array('id', 'label', 'pid', 'date_created')));
	}
	public function addAction() {
		$pid = (int) router::_()->getPart(2);
		document::_()->setTitle(lang::_('ADD_NEWS'));
		document::_()->addScript('admin.news.edit', $this->getModule()->getUrl(). '/js/admin.news.edit.js');
		document::_()->setContent( $this->getView()->getEditForm(array(), $pid) );
	}
	public function editAction() {
		$id = (int) router::_()->getPart(2);
		$data = $this->getModel()->getById($id);
		document::_()->setTitle(lang::_('EDIT_NEWS'). ' '. $data['label']);
		document::_()->addScript('admin.news.edit', $this->getModule()->getUrl(). '/js/admin.news.edit.js');
		document::_()->setContent( 
			$this->getView()->getEditForm(
				$data
			)
		);
	}
	public function removeAction() {
		$id = (int) router::_()->getPart(2);
		if($id) {
			$news = $this->getModel()->getById($id);
			if($this->getModel()->removeById($id)) {
				$this->addData('id', $id);
				frame::_()->getModule('programs')->getModel()->setRemoveNews( $news['pid'] );
			} else
				$this->pushError ($this->getModel()->getErrors());
		} else
			$this->pushError (lang::_('INVALID_ID'));
	}
	public function saveAction() {
		if(($id = $this->getModel()->save(req::get('post')))) {
			$news = $this->getModel()->getById($id);
			$notifySubscribers = (int) req::getVar('notify_subscribers');
			if($this->getModel()->getLastDbAction() == 'INSERT') {	// For new added - redirect user to edit URL
				$this->addData('edit_link', $this->getModule()->getEditLink($id));
				frame::_()->getModule('programs')->getModel()->setAddNews( $news['pid'] );
				if($notifySubscribers)
					$this->getModel()->sendNotifyAddNews($news);
			} elseif($notifySubscribers) {
				$this->getModel()->sendNotifyEditNews($news);
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