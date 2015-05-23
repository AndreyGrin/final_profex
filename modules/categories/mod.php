<?php
class categoriesMod extends module {
	public function getCategoryLink($category) {
		return uri::getLink('programs/list/category/'. $category['id']);
	}
	public function getLink($category) {
		return $this->getCategoryLink($category);
	}
	public function getEditLink($cid) {
		return uri::getAdminLink('categories/edit/'. $cid);
	}
	public function getRemoveLink($cid) {
		return uri::getAdminLink('categories/remove/'. $cid);
	}
}