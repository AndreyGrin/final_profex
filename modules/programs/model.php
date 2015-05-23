<?php
class programsModel extends model {
	private $_p2fTbl = 'programs2files';
	private $_p2cTbl = 'programs2categories';
	private $_p2lTbl = 'programs2locations';
	private $_p2hTbl = 'programs2help_type';
	private $_donateTbl = 'donate';
	private $_getFull = false;
	public function __construct($code) {
		parent::__construct($code);
		$this->_setFields(array(
			'label' => array('valid' => 'notEmpty', 'label' => lang::_('PROGRAM_LABEL')),
			'description' => array('label' => lang::_('PROGRAM_DESC')),
			'views' => array('label' => lang::_('PROGRAM_VIEWS')),
			'subscribed' => array('label' => lang::_('SUBSCRIBERS')),
			'news' => array('label' => lang::_('NEWS')),
			'required_amount' => array('label' => lang::_('REQUIRED_AMOUNT')),
			'received_amount' => array('label' => lang::_('RECEIVED_AMOUNT')),
		));
		$this->_setTbl('programs');
	}
	protected function _afterSave($id, $data) {
		$this->unbindFiles($id);
		if(isset($data['img_id']) && !empty($data['img_id'])) {
			$this->bindFiles($id, $data['img_id']);
		}
		$this->unBind($this->_p2cTbl, array('pid' => $id));
		$this->unBind($this->_p2lTbl, array('pid' => $id));
		$this->unBind($this->_p2hTbl, array('pid' => $id));
		if(isset($data['categories_ids']) && !empty($data['categories_ids'])) {
			$this->bind($this->_p2cTbl, array(
				'pid' => $id,
				'cid' => array_map('intval', $data['categories_ids']),
			));
		}
		if(isset($data['locations_ids']) && !empty($data['locations_ids'])) {
			$this->bind($this->_p2lTbl, array(
				'pid' => $id,
				'lid' => array_map('intval', $data['locations_ids']),
			));
		}
		if(isset($data['help_types_ids']) && !empty($data['help_types_ids'])) {
			$this->bind($this->_p2hTbl, array(
				'pid' => $id,
				'hid' => array_map('intval', $data['help_types_ids']),
			));
		}
	}
	protected function _afterGetList($fromDb) {
		$programs = array();
		$prodIdToI = array();
		foreach($fromDb as $p) {
			if(isset($prodIdToI[ $p['id'] ])) {
				$pIter = $prodIdToI[ $p['id'] ];
			} else {
				$pIter = $prodIdToI[ $p['id'] ] = count($programs);
				$programs[ $pIter ] = $p;
			}
		}
		if($this->_getFull) {
			foreach($programs as $i => $p) {
				$programs[ $i ]['files'] = $this->getProgramFiles( $p['id'] );
				if(empty($programs[ $i ]['files']))
					$programs[ $i ]['files'] = array();
				
				$programs[ $i ]['categories_ids'] = $programs[ $i ]['locations_ids'] = $programs[ $i ]['help_types_ids'] = array();
				$programs[ $i ]['categories'] = $this->getCategories( $p['id'] );
				if(empty($programs[ $i ]['categories']))
					$programs[ $i ]['categories'] = array();
				else {
					foreach($programs[ $i ]['categories'] as $c) {
						$programs[ $i ]['categories_ids'][] = $c['id'];
					}
				}
				$programs[ $i ]['locations'] = $this->getLocations( $p['id'] );
				if(empty($programs[ $i ]['locations']))
					$programs[ $i ]['locations'] = array();
				else {
					foreach($programs[ $i ]['locations'] as $l) {
						$programs[ $i ]['locations_ids'][] = $l['id'];
					}
				}
				$programs[ $i ]['help_types'] = $this->getHelpTypes( $p['id'] );
				if(empty($programs[ $i ]['help_types']))
					$programs[ $i ]['help_types'] = array();
				else {
					foreach($programs[ $i ]['help_types'] as $h) {
						$programs[ $i ]['help_types_ids'][] = $h['id'];
					}
				}
			}
		}
		$this->_getFull = false;
		return $programs;
	}
	public function getCategories($id) {
		return frame::_()->getModule('categories')->getModel()->getBinded(array(
			'pid' => $id,
		), array(
			$this->_p2cTbl => 'cid',
		));
	}
	public function getLocations($id) {
		return frame::_()->getModule('locations')->getModel()->getBinded(array(
			'pid' => $id,
		), array(
			$this->_p2lTbl => 'lid',
		));
	}
	public function getHelpTypes($id) {
		return frame::_()->getModule('help_types')->getModel()->getBinded(array(
			'pid' => $id,
		), array(
			$this->_p2hTbl => 'hid',
		));
	}
	public function getFullList($conditions = array(), $sortOrder = '') {
		$this->_getFull = true;
		if(!empty($sortOrder)) {
			$this->setSortOrder($sortOrder);
		}
		return $this->getList($conditions);
	}
	public function getFullById($id) {
		$this->_getFull = true;
		return $this->getById($id);
	}
	public function getProgramFiles($pid) {
		$filesTbl = frame::_()->getModule('files')->getModel()->getTbl();
		$files = db::_()->get('SELECT f.*, f2p.type FROM `'. $this->_p2fTbl. '` f2p 
			INNER JOIN `'. $filesTbl. '` f ON f.id = f2p.fid', ALL, array('pid' => $pid));
		if($files) {
			$uploadsUrl = frame::_()->getModule('files')->getModel()->getUploadsUrl();
			foreach($files as $i => $f) {
				$files[ $i ] = $this->prepareFileData( $f, $uploadsUrl );
			}
			return $files;
		}
		return false;
	}
	public function prepareFileData($file, $uploadsUrl = '') {
		if(empty($uploadsUrl))
			$uploadsUrl = frame::_()->getModule('files')->getModel()->getUploadsUrl();
		$file['url'] = $uploadsUrl. '/'. $file['alias'];
		return $file;
	}
	public function unbindFiles($pid) {
		return $this->unBind($this->_p2fTbl, array('pid' => $pid));
	}
	public function unbindFile($pid, $fid) {
		if(db::_()->query('DELETE FROM `'. $this->_p2fTbl. '` WHERE '. db::_()->toQuery(array('pid' => $pid, 'fid' => $fid), 'AND'))) {
			// Remove it from here - when we will have gallery for our files
			if(frame::_()->getModule('files')->getModel()->remove( $fid )) {
				return true;
			} else
				$this->pushError(frame::_()->getModule('files')->getModel()->getErrors());
		} else
			$this->pushError (db::_()->getLastError ());
		return false;
	}
	public function bindFiles($pid, $fIds) {
		if(!is_array($fIds))
			$fIds = array($fIds);
		return $this->bind($this->_p2fTbl, array(
			'pid' => $pid,
			'fid' => $fIds,
		));
	}
	public function setViewed($pid) {
		db::_()->query('UPDATE `'. $this->_tbl. '` SET views = views + 1 WHERE id = '. $pid);
	}
	public function setSubscribed($pid) {
		db::_()->query('UPDATE `'. $this->_tbl. '` SET subscribed = subscribed + 1 WHERE id = '. $pid);
	}
	public function setUnsubscribed($pid) {
		db::_()->query('UPDATE `'. $this->_tbl. '` SET subscribed = IF(subscribed - 1 >= 0, subscribed - 1, 0) WHERE id = '. $pid);
	}
	public function setAddNews($pid) {
		db::_()->query('UPDATE `'. $this->_tbl. '` SET news = news + 1 WHERE id = '. $pid);
	}
	public function setRemoveNews($pid) {
		db::_()->query('UPDATE `'. $this->_tbl. '` SET news = IF(news - 1 >= 0, news - 1, 0) WHERE id = '. $pid);
	}
	public function getIdsByCategory($id) {
		return db::_()->get("SELECT pid FROM $this->_p2cTbl WHERE cid = '$id'", COL);
	}
	public function getIdsByLocation($id) {
		return db::_()->get("SELECT pid FROM $this->_p2lTbl WHERE lid = '$id'", COL);
	}
	public function getIdsByHelpType($id) {
		return db::_()->get("SELECT pid FROM $this->_p2hTbl WHERE hid = '$id'", COL);
	}
	public function donate($data) {
		$pid = isset($data['pid']) ? (int) $data['pid'] : 0;
		if($pid) {
			$amount = isset($data['amount']) ? (int) $data['amount'] : 0;
			if($amount) {
				db::_()->query("UPDATE $this->_tbl SET received_amount = received_amount + $amount WHERE id = $pid");
				//
				$uid = frame::_()->getModule('user')->getModel()->getLoggedInId();
				if($uid) {
					if(!db::_()->get("SELECT COUNT(*) AS total FROM $this->_donateTbl WHERE uid = $uid AND pid = $pid", ONE)) {
						db::_()->query("INSERT INTO $this->_donateTbl (uid, pid, amount) VALUES ($uid, $pid, $amount)");
					}
				}
				return true;
			} else
				$this->pushError (lang::_('INVALID_AMOUNT'));
		} else
			$this->pushError(lang::_('INVALID_ID'));
	}
	public function getDonatedUsers($pid) {
		$usersTbl = frame::_()->getModule('user')->getModel()->getTbl();
		return db::_()->get("SELECT u.* FROM $usersTbl u 
				INNER JOIN $this->_donateTbl d ON d.uid = u.id
				WHERE d.pid = $pid");
	}
	public function getTotalDonate() {
		return (int) db::_()->get( "SELECT SUM(amount) AS sum FROM $this->_donateTbl", ONE );
	}
}