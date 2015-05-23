<?php
class newsView extends view {
	public function getEditForm($data = array(), $pid = 0) {
		$edit = !empty($data);
		$this->assign('data', $data);
		$this->assign('edit', $edit);
		$this->assign('pid', $edit ? $data['pid'] : $pid);
		return parent::getContent('editForm');
	}
	public function listForProgram($pid) {
		$this->assign('news', $this->getModel()->getListForProgr($pid));
		return parent::getContent('listForProgram');
	}
	public function showListForProgram($pid) {
		echo $this->listForProgram($pid);
	}
}