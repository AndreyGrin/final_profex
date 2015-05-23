<?php
class help_typesMod extends module {
	public function getHelpTypeLink($data) {
		return uri::getLink('programs/list/help_type/'. $data['id']);
	}
	public function getLink($data) {
		return $this->getHelpTypeLink($data);
	}
	public function getEditLink($id) {
		return uri::getAdminLink('help_types/edit/'. $id);
	}
	public function getRemoveLink($id) {
		return uri::getAdminLink('help_types/remove/'. $id);
	}
}