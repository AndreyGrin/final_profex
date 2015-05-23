<?php
class newsMod extends module {
	public function getNewsLink($news) {
		return uri::getLink('news/view/'. $news['id']);
	}
	public function getLink($news) {
		return $this->getNewsLink($news);
	}
	public function getEditLink($id) {
		return uri::getAdminLink('news/edit/'. $id);
	}
	public function getRemoveLink($id) {
		return uri::getAdminLink('news/remove/'. $id);
	}
}