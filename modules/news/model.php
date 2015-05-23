<?php
class newsModel extends modelSimple {
	public function __construct($code) {
		parent::__construct($code);
		$this->_setFields(array(
			'label' => array('valid' => 'notEmpty', 'label' => lang::_('NEWS_LABEL')),
			'description' => array('label' => lang::_('NEWS_CONTENT')),
			'pid' => array('label' => lang::_('NEWS_PROGRAM')),
		));
		$this->_setTbl('news');
	}
	public function getListForProgr($pid, $fields = array()) {
		$condition = array('pid' => $pid);
		if(!empty($fields)) {
			$condition['FIELDS'] = $fields;
		}
		return $this->getList( $condition );
	}
	public function sendNotifyAddNews($news) {
		$subscribers = frame::_()->getModule('user')->getModel()->getSubscribedTo( $news['pid'] );
		if(!empty($subscribers)) {
			$mailer = frame::_()->getModule('mail');
			$program = frame::_()->getModule('programs')->getModel()->getById( $news['pid'] );
			foreach($subscribers as $s) {
				$mailer->send($s['email'], lang::_('PROGRAM_NEWS_ADDED_SUBJECT'), lang::_('PROGRAM_NEWS_ADDED_CONTENT'), array('data' => array(
					'program' => $program,
					'user' => $s,
					'news' => $news,
				)));
			}
		}
	}
	public function sendNotifyEditNews($news) {
		$subscribers = frame::_()->getModule('user')->getModel()->getSubscribedTo( $news['pid'] );
		if(!empty($subscribers)) {
			$mailer = frame::_()->getModule('mail');
			$program = frame::_()->getModule('programs')->getModel()->getById( $news['pid'] );
			foreach($subscribers as $s) {
				$mailer->send($s['email'], lang::_('PROGRAM_NEWS_EDITED_SUBJECT'), lang::_('PROGRAM_NEWS_EDITED_CONTENT'), array('data' => array(
					'program' => $program,
					'user' => $s,
					'news' => $news,
				)));
			}
		}
	}
	
}