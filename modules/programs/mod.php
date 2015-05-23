<?php
class programsMod extends module {
	public function getProgrLink($program) {
		return uri::getLink('programs/view/'. $program['id']);
	}
	public function getLink($program) {
		return $this->getProgrLink($program);
	}
	public function getEditLink($pid) {
		return uri::getAdminLink('programs/edit/'. $pid);
	}
	public function getRemoveLink($pid) {
		return uri::getAdminLink('programs/remove/'. $pid);
	}
	public function getSearchAction() {
		$action = 'programs/list';
		$allRouteParts = router::_()->getParts();
		if(count($allRouteParts) == 4 && $allRouteParts[0] == 'programs' && $allRouteParts[1] == 'list') {
			$action = implode('/', $allRouteParts);
		}
		return uri::getLink($action);
	}
}