<?php
/*Many functions - is common for oour models, but not common for all models - so, let's make one more programm layer*/
abstract class modelSimple extends model {
	public function getListForParentSelect($params = array()) {
		$res = array();
		$includeNone = isset($params['includeNone']) ? $params['includeNone'] : false;
		$id = isset($params['id']) ? $params['id'] : 0;
		if($includeNone) {
			$res[0] = lang::_('NONE_LABEL');
		}
		$condition = $id ? array('!=' => array('id' => $id)) : array();
		$data = $this->getList( $condition );
		if(!empty($data)) {
			foreach($data as $c) {
				$res[ $c['id'] ] = $c['label'];
			}
		}
		return $res;
	}
	public function getListForSelect() {
		return $this->getListForParentSelect(array('ignoreParentBuild' => true));
	}
}