<?php
/**
 * For future developments
 */
abstract class widgetView extends view {
	public function getWidgetContent() {
		return parent::getContent('widget');
	}
	public function showWidget() {
		echo $this->getWidgetContent();
	}
}