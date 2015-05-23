<?php
/*Free to modify => flexibility*/
abstract class model extends baseMvc {
	protected $_fields = array();
	protected $_tbl = '';
	protected $_validationErrors = array(
		'notEmpty' => 'ERROR_FIELD_NOT_EMPTY',
		'isNumeric' => 'ERROR_FIELD_IS_NUMERIC',
		'isEmail' => 'ERROR_FIELD_IS_EMAIL',
	);
	protected $_sortOrder = '';
	protected $_limit = '';
	protected $_groupBy = '';
	private $_lastDbAction = '';
	protected $_id = 'id';	// ID field name
	public function validateFields($data) {
		$res = true;
		if(!empty($this->_fields)) {
			foreach($this->_fields as $key => $params) {
				if(!isset($params['valid'])) continue;
				$validation = is_array($params['valid']) ? $params['valid'] : array($params['valid']);
				foreach($validation as $vMethod) {
					if(!$this->$vMethod( $data[$key] )) {
						$this->pushError(sprintf(lang::_($this->_validationErrors[$vMethod]), $params['label']), $key);
						$res = false;
					}
				}
			}
		}
		return $res;
	}
	protected function _setLastDbAction($action) {
		$this->_lastDbAction = $action;
	}
	public function getLastDbAction() {
		return $this->_lastDbAction;
	}
	public function setSortOrder($sortOrder) {
		$this->_sortOrder = $sortOrder;
	}
	public function notEmpty($val) {
		$val = trim($val);
		return !empty($val);
	}
	public function isNumeric($val) {
		return is_numeric($val);
	}
	public function isEmail($val) {
		return filter_var($val, FILTER_VALIDATE_EMAIL);
	}
	protected function _setFields($fields) {
		$this->_fields = $fields;
	}
	protected function _removeField($key) {
		if(isset($this->_fields[ $key ]))
			unset( $this->_fields[ $key ] );
	}
	public function getFields() {
		return $this->_fields;
	}
	protected function _setTbl($tbl) {
		$this->_tbl = $tbl;
	}
	public function getTbl() {
		return $this->_tbl;
	}
	public function setLimit($limit) {
		$this->_limit = $limit;
	}
	public function getLimit() {
		return $this->_limit;
	}
	public function setGroupBy($groupBy) {
		$this->_groupBy = $groupBy;
	}
	public function getGroupBy() {
		return $this->_groupBy;
	}
	protected function _prepareGetQuery($query) {
		return $query;
	}
	protected function _prepareGetConditions($conditions) {
		return $conditions;
	}
	public function getList($conditions = array()) {
		$fields = '*';
		if(is_array($conditions) && isset($conditions['FIELDS'])) {
			$fields = is_array($conditions['FIELDS']) ? implode(',', $conditions['FIELDS']) : $conditions['FIELDS'];
			unset($conditions['FIELDS']);
		}
		$query = $this->_prepareGetQuery( 'SELECT '. $fields. ' FROM `'. $this->_tbl. '` mTbl' );	// main table
		$conditions = $this->_prepareGetConditions( $conditions );
		
		if(!empty($conditions))
			$query .= ' WHERE '. db::_()->toQuery($conditions, 'AND');
		if(!empty($this->_groupBy)) {
			$query .= ' GROUP BY '. $this->_groupBy;
			$this->_groupBy = '';
		}
		if(!empty($this->_sortOrder)) {
			$query .= ' ORDER BY '. $this->_sortOrder;
			$this->_sortOrder = '';
		}
		if(!empty($this->_limit)) {
			$query .= ' LIMIT '. $this->_limit;
			$this->_limit = '';
		}
		$dataFromDb = db::_()->get($query, ALL);
		if($dataFromDb) {
			$data = $this->_afterGetList($dataFromDb);
			return $data;
		}
		return false;
	}
	protected function _afterGetList($data) {
		return $data;
	}
	public function remove($ids) {
		// In this way we can extend this code in future
		if(!is_array($ids)) {
			$ids = array($ids);
		}
		$ids = array_map('intval', $ids);
		foreach($ids as $id) {
			$this->removeById($id);
		}
	}
	public function removeById($id) {
		$id = (int) $id;
		if($id) {
			if(db::_()->query('DELETE FROM `'. $this->_tbl. '` WHERE '. $this->_id. ' = "'. $id. '"')) {
				return true;
			} else
				$this->pushError(db::_()->getLastError());
		} else
			$this->pushError (lang::_('INVALID_ID'));
		return false;
	}
	public function getById($id) {
		$id = (int) $id;
		$data = $this->getList(array($this->_id => $id));
		return $data ? array_shift($data) : false;
	}
	public function getBy($field, $value) {
		$data = $this->getList(array($field => $value));
		return $data ? $data : false;
	}
	public function getOneBy($field, $value) {
		$data = $this->getBy($field, $value);
		return $data ? array_shift($data) : false;
	}
	public function save($data) {
		if($this->validateFields($data)) {
			$id = isset($data[ $this->_id ]) ? (int) $data[ $this->_id ] : 0;
			$action = $id ? 'UPDATE' : 'INSERT';
			$dbData = array();
			foreach($this->getFields() as $key => $fData) {
				if(isset($data[ $key ]))
					$dbData[ $key ] = $data[ $key ];
			}
			$query = $action. ' `'. $this->_tbl. '` SET '. db::_()->toQuery($dbData, ',');
			if($action == 'UPDATE')
				$query .= ' WHERE '. db::_()->toQuery(array($this->_id => $id), 'AND');
			if(db::_()->query($query)) {
				if(!$id)
					$id = db::_()->getLastId();
				$this->_afterSave($id, $data);
				$this->_setLastDbAction( $action );
				return $id;
			} else {
				$this->pushError(db::_()->getLastError());
			}
		}
		return false;
	}
	protected function _afterSave($id, $data) {
		
	}
	public function bind($tbl, $data) {
		$valuesArr = $values = $originalId = array();
		$totalElements = 0;
		foreach($data as $k => $v) {
			if(is_array($v)) {
				$totalElements = count($v);	// All binded data should have same amount of values
			} else {
				$originalId = array('key' => $k, 'val' => $v);
			}
		}
		foreach($data as $k => $v) {
			for($i = 0; $i < $totalElements; $i++) {
				if(!isset($valuesArr[ $i ]))
					$valuesArr[ $i ] = array();
				$valuesArr[ $i ][] = $k == $originalId['key'] ? $originalId['val'] : $v[ $i ];
			}
		}
		foreach($valuesArr as $vals) {
			$values[] = '('. implode(',', $vals). ')';
		}
		$query = "INSERT INTO `$tbl` (". implode(',', array_keys($data)). ") VALUES ". implode(',', $values);
		if(db::_()->query($query)) {
			return true;
		} else {
			$this->pushError(db::_()->getLastError());
		}
		return false;
	}
	public function unBind($tbl, $data) {
		$value = reset($data);
		$key = key($data);
		$query = "DELETE FROM `$tbl` WHERE `$key` = '$value'";
		if(db::_()->query($query)) {
			return true;
		} else {
			$this->pushError(db::_()->getLastError());
		}
		return false;
	}
	public function reBind($tbl, $data) {
		$unbindData = array();
		foreach($data as $k => $v) {
			if(!is_array($v)) {
				$unbindData[ $k ] = $v;
				break;
			}
		}
		return $this->unBind($tbl, $unbindData) && $this->bind($tbl, $data);
	}
	public function getBinded($data, $tbls = array()) {
		$bindField = key($data);
		$bindValue = array_shift($data);
		if(!empty($tbls)) {	// Bind with additional normal table
			$bindTbl = key($tbls);
			$bindTblId = array_shift($tbls);
			$query = "SELECT `$this->_tbl`.* FROM `$this->_tbl` 
				INNER JOIN `$bindTbl` ON `$bindTbl`.`$bindTblId` = `$this->_tbl`.`$this->_id`
				WHERE `$bindTbl`.`$bindField` = '$bindValue'";
		} else {	// Bind with 1per1 structure
			$query = "SELECT `$this->_tbl`.* FROM `$this->_tbl` 
				WHERE `$this->_tbl`.`$bindField` = '$bindValue'";
		}
		$data = db::_()->get($query, ALL);
		return $data ? $data : false;
	}
	public function getTotal($conditions = array()) {
		$query = "SELECT COUNT(*) AS total FROM $this->_tbl";
		if(!empty($conditions))
			$query .= ' WHERE '. db::_()->toQuery($conditions, 'AND');
		return (int) db::_()->get( $query, ONE );
	}
	public function getSum($col, $conditions = array()) {
		$query = "SELECT SUM($col) AS sum FROM $this->_tbl";
		if(!empty($conditions))
			$query .= ' WHERE '. db::_()->toQuery($conditions, 'AND');
		return (int) db::_()->get( $query, ONE );
	}
}