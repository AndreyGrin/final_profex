<?php
class utils {
	 static public function getRandStr($length = 10, $allowedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890', $params = array()) {
        $result = '';
        $allowedCharsLen = strlen($allowedChars);
		if(isset($params['only_lowercase']) && $params['only_lowercase']) {
			$allowedChars = strtolower($allowedChars);
		}
        while(strlen($result) < $length) {
          $result .= substr($allowedChars, rand(0, $allowedCharsLen), 1);
        }

        return $result;
    }
}