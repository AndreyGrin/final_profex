<?php
class dashboardView extends view {
	public function getIndex($data) {
		$this->assign('data', $data);
		return parent::getContent('index');
	}
}