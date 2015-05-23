<?php
class categories_widgetView extends widgetView {
	public function getWidgetContent() {
		$categories = frame::_()->getModule('categories')->getModel()->getList();
		if($categories) {
			$this->assign('categories', $categories);
			return parent::getWidgetContent();
		}
		return '';
	}
}