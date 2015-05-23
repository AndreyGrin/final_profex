<?php
class locations_widgetView extends widgetView {
	public function getWidgetContent() {
		$locations = frame::_()->getModule('locations')->getModel()->getList();
		if($locations) {
			$this->assign('locations', $locations);
			return parent::getWidgetContent();
		}
		return '';
	}
}