<?php
class mailModel extends modelSimple {
	public function __construct($code) {
		parent::__construct($code);
		$this->_setFields(array(
			'to_address' => array('valid' => 'notEmpty', 'label' => lang::_('MAIL_TO')),
			'subject' => array('valid' => 'notEmpty', 'label' => lang::_('MAIL_SUBJECT')),
			'content' => array('valid' => 'notEmpty', 'label' => lang::_('MAIL_CONTENT')),
			'res' => array('label' => lang::_('MAIL_RESULT')),
		));
		$this->_setTbl('mail_log');
	}
	public function saveLog($to, $subject, $content, $res) {
		return $this->save(array(
			'to_address' => $to,
			'subject' => $subject,
			'content' => $content,
			'res' => (int) $res,
		));
	}
}