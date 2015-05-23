<?php
class help_types_widgetView extends widgetView {
	public function getWidgetContent() {
		$helpTypes = frame::_()->getModule('help_types')->getModel()->getList();
		if($helpTypes) {
			$this->assign('help_types', $helpTypes);
			return parent::getWidgetContent();
		}
		return '';
	}
}