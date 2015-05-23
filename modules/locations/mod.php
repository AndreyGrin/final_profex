<?php
class locationsMod extends module {
	public function getLocationLink($data) {
		return uri::getLink('programs/list/location/'. $data['id']);
	}
	public function getLink($data) {
		return $this->getLocationLink($data);
	}
	public function getEditLink($id) {
		return uri::getAdminLink('locations/edit/'. $id);
	}
	public function getRemoveLink($id) {
		return uri::getAdminLink('locations/remove/'. $id);
	}
}