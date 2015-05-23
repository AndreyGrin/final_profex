<?php
class userModel extends model {
	private $_rolesTbl = 'roles';
	private $_u2pTbl = 'users2programs';
	private $_editId = 0;
	public function __construct($code) {
		parent::__construct($code);
		$this->_setFields(array(
			'login' => array('valid' => 'notEmpty', 'label' => lang::_('LOGIN')),
			'passwd' => array('valid' => 'notEmpty', 'label' => lang::_('PASSWORD')),
			'email' => array('valid' => array('notEmpty', 'isEmail'), 'label' => lang::_('EMAIL')),
			'first_name' => array('label' => lang::_('FIRST_NAME')),
			'last_name' => array('label' => lang::_('LAST_NAME')),
			'role_id' => array('label' => lang::_('ROLE')),
			'active' => array('label' => lang::_('ACTIVE')),
		));
		$this->_setTbl('users');
	}
	public function login($login, $passwd) {
		$user = $this->getByLogin($login);
		if($user && (int) $user['active']) {
			$enteredPasswdHash = $this->passdwToHash($passwd, $this->getSaltFromPassdw($user['passwd']));
			if($enteredPasswdHash == $user['passwd']) {
				unset($user['passwd']);
				$this->setLoggedIn($user);
				return true;
			} else
				$this->pushError(lang::_('INVALID_LOGIN_DATA'));
		} else 
			$this->pushError(lang::_('INVALID_LOGIN_DATA'));
		return false;
	}
	protected function _prepareGetQuery($query) {
		return "SELECT mTbl.*, `$this->_rolesTbl`.code AS role_code FROM `$this->_tbl` mTbl
			INNER JOIN `$this->_rolesTbl` ON mTbl.role_id = `$this->_rolesTbl`.id";
	}
	protected function _prepareGetConditions($conditions) {
		if(isset($conditions[ $this->_id ])) {
			$conditions[ 'mTbl.'. $this->_id ] = $conditions[ $this->_id ];
			unset($conditions[ $this->_id ]);
		}
		return $conditions;
	}
	public function getByLogin($login) {
		return $this->getOneBy('login', $login);
	}
	protected function _afterGetList($users) {
		if(!empty($users)) {
			foreach($users as $i => $u) {
				$users[$i]['roles'] = array( $users[$i]['role_code'] );	// This was done - to be able extend this functionality to many roles per user in future
				$users[$i]['subscribed'] = $this->getSubscribed( $users[$i]['id'] );
			}
		}
		return $users;
	}
	public function getSubscribed($uid) {
		$resFromDb = db::_()->get("SELECT pid FROM $this->_u2pTbl WHERE uid = '$uid'", COL);
		return empty($resFromDb) ? array() : $resFromDb;
	}
	public function passdwToHash($passwd, $salt = '') {
		if(empty($salt))
			$salt = mt_rand(1, 99999);
		return md5($passwd. $salt). ':'. $salt;
	}
	public function getSaltFromPassdw($passwd) {
		$hashSalt = explode(':', $passwd);
		return isset($hashSalt[1]) ? $hashSalt[1] : false;
	}
	public function setLoggedIn($user) {
		req::setVar('user', $user, 'session');
	}
	public function getLoggedIn() {
		$user = req::getVar('user', 'session');
		return $user ? $user : false;
	}
	public function getLoggedInId() {
		$user = $this->getLoggedIn();
		return $user ? $user['id'] : false;
	}
	public function addSubscription($uid, $pid) {
		frame::_()->getModule('programs')->getModel()->setSubscribed( $pid );
		return $this->bind($this->_u2pTbl, array(
			'uid' => $uid,
			'pid' => array($pid),
		));
	}
	public function subscribe($data) {
		$loggedId = $this->getLoggedInId();
		if(!$loggedId) {	// If not logged-in
			$loggedId = $this->createSubscriber($data);
		}
		if($loggedId) {
			$pid = isset($data['pid']) ? (int) $data['pid'] : 0;
			if($pid) {
				if($this->addSubscription($loggedId, $pid)) {
					return $loggedId;
				} else
					return false;
			}
			return $loggedId;
		}
		return false;
	}
	public function createSubscriber($data) {
		$data['login'] = $this->generateUsernameFromEmail($data['email']);
		$data['passwd'] = $this->passdwToHash( $data['passwd'] );
		$id = $this->save( $data );
		if($id) {
			$this->sendWelcomeEmail($id, $data['passwd']);
			return $id;
		}
		return false;
	}
	public function isEmail($val) {
		if(parent::isEmail($val)) {
			$userByEmail = $this->getOneBy('email', $val);
			if($userByEmail && $userByEmail['id'] != $this->_editId) {
				return false;
			}
			return true;
		}
		return false;
	}
	public function sendWelcomeEmail($id, $passwd) {
		$user = $this->getById($id);
		if($user) {
			unset($user['passwd']);
			$subject = lang::_('WELCOME_EMAIL_SUBJECT');
			$content = lang::_('WELCOME_EMAIL_CONTENT');
			foreach($user as $k => $v) {
				if(is_array($v)) continue;
				$subject = str_replace('['. $k .']', $v, $subject);
				$content = str_replace('['. $k .']', $v, $content);
			}
			$content = str_replace('[passwd]', $passwd, $content);
			frame::_()->getModule('mail')->send($user['email'], $subject, $content);
		}
	}
	public function generatePass() {
		return utils::getRandStr();
	}
	public function generateUsernameFromEmail($email, $sufix = 0) {
		$usernameDomain = explode('@', $email);
		$username = $usernameDomain[0];
		if(!empty($sufix))
			$username .= '_'. $sufix;
		if($this->getByLogin($username)) {
			return $this->generateUsernameFromEmail($email, $sufix + 1);
		}
		return $username;
	}
	public function logout() {
		req::clearVar('user', 'session');
		return true;
	}
	public function updateCurrentSubscribedList() {
		$user = $this->getLoggedIn();
		if($user) {
			$user['subscribed'] = $this->getSubscribed($user['id']);
			$this->setLoggedIn( $user );
		}
	}
	public function getRolesList() {
		return db::_()->get("SELECT * FROM $this->_rolesTbl");
	}
	public function getRolesListForSelect() {
		$res = array();
		$roles = $this->getRolesList();
		foreach($roles as $r) {
			$res[ $r['id'] ] = $r['label'];
		}
		return $res;
	}
	public function saveEdit($data) {
		$this->_removeField('passwd');
		$this->_editId = $data['id'];
		$data['active'] = isset($data['active']) ? $data['active'] : 0;
		return $this->save($data);
	}
	public function getSubscribedTo($pid) {
		return $this->getBinded(array(
			'pid' => $pid,
		), array(
			$this->_u2pTbl => 'uid',
		));
	}
	public function saveProfile($data) {
		$id = $this->getLoggedInId();
		$data['passwd'] = trim($data['passwd']);
		if(empty($data['passwd'])) {
			$this->_removeField('passwd');
		} else {
			$data['passwd'] = $this->passdwToHash( $data['passwd'] );
		}
		if(isset($data['active']))
			unset($data['active']);
		if(isset($data['role_id']))
			unset($data['role_id']);
		$this->_editId = $id;
		$data['id'] = $id;
		if($this->save($data)) {
			$this->setLoggedIn( $this->getById( $id ) );	// Nice:)
			return true;
		}
		return false;
	}
	public function unsubscribe($uid, $pid) {
		db::_()->query("DELETE FROM $this->_u2pTbl WHERE uid = $uid AND pid = $pid");
		frame::_()->getModule('programs')->getModel()->setUnsubscribed( $pid );
		$user = $this->getLoggedIn();
		if($user['id'] == $uid) {
			unset($user['subscribed'][ array_shift(array_keys($user['subscribed'], $pid)) ]);	// wow:)
			$this->setLoggedIn($user);
		}
		return true;
	}
}