<?php
class userMod extends module {
	public function isAdmin() {
		return $this->userHaveRole( ADMIN );
	}
	public function isLoggedIn() {
		return $this->getModel()->getLoggedInId();
	}
	public function userHaveRole($roleCode) {
		$user = $this->getModel()->getLoggedIn();
		return ($user && in_array($roleCode, $user['roles'])) ? true : false;
	}
	public function loadFrontendAssets() {
		document::_()->addScript('frontend.user', $this->getUrl(). '/js/frontend.user.js');
	}
	public function isSubscribed($pid) {
		$user = $this->getModel()->getLoggedIn();
		if($user && $user['subscribed'] && in_array($pid, $user['subscribed'])) {
			return true;
		}
		return false;
	}
	public function getEditLink($id) {
		return uri::getAdminLink('user/edit/'. $id);
	}
	public function getRemoveLink($id) {
		return uri::getAdminLink('user/remove/'. $id);
	}
}