<?php
class mailMod extends module {
	public function send($to, $subject, $message, $params = array()) {
		$data = isset($params['data']) ? $params['data'] : array();
		$subject = $this->prepare($subject, $data);
		$message = $this->prepare($message, $data);
		$headers = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=UTF-8";
		$headers[] = "From: Profex <team@profex.dev>";
		$headers[] = "Subject: {$subject}";
		$headers[] = "X-Mailer: PHP/". phpversion();
		$sendMailRes = mail($to, $subject, $message, implode("\r\n", $headers));
		$this->getModel()->saveLog($to, $subject, $message, $sendMailRes);
		return $sendMailRes;
	}
	public function getRemoveLink($id) {
		return uri::getAdminLink('mail/remove/'. $id);
	}
	public function prepare($str, $data, $prefix = '') {
		if(!empty($data) && is_array($data)) {
			foreach($data as $k => $v) {
				if(is_array($v)) {
					$str = $this->prepare($str, $v, (empty($prefix) ? '' : $prefix. '.'). $k);
				} else
					$str = str_replace('['. (empty($prefix) ? '' : $prefix. '.'). $k. ']', $v, $str);
			}
		}
		return $str;
	}
}