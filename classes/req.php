<?php
class req {
	static public function getVar($name, $from = 'all', $default = NULL) {
        $from = strtolower($from);
        if($from == 'all') {
			if(isset($_GET[$name])) {
                $from = 'get';
            } elseif(isset($_POST[$name])) {
                $from = 'post';
            }
        }
        switch($from) {
            case 'get':
                if(isset($_GET[$name]))
                    return $_GET[$name];
            break;
            case 'post':
                if(isset($_POST[$name]))
                    return $_POST[$name];
            break;
            case 'file':
            case 'files':
                if(isset($_FILES[$name]))
                    return $_FILES[$name];
                break;
            case 'session':
                if(isset($_SESSION[$name]))
                    return $_SESSION[$name];
            break;
            case 'server':
                if(isset($_SERVER[$name]))
                    return $_SERVER[$name];
                break;
        }
        return $default;
    }
    static public function setVar($name, $val, $in = 'input') {
        $in = strtolower($in);
        switch($in) {
            case 'get':
                $_GET[$name] = $val;
            break;
            case 'post':
                $_POST[$name] = $val;
            break;
            case 'session':
                $_SESSION[$name] = $val;
            break;
        }
    }
    static public function clearVar($name, $in = 'input') {
        $in = strtolower($in);
        switch($in) {
            case 'get':
                if(isset($_GET[$name]))
                    unset($_GET[$name]);
            break;
            case 'post':
                if(isset($_POST[$name]))
                    unset($_POST[$name]);
            break;
            case 'session':
                if(isset($_SESSION[$name]))
                    unset($_SESSION[$name]);
            break;
        }
    }
    static public function get($what) {
        $what = strtolower($what);
        switch($what) {
            case 'get':
                return $_GET;
                break;
            case 'post':
                return $_POST;
                break;
            case 'session':
                return $_SESSION;
                break;
			case 'files':
				return $_FILES;
				break;
        }
        return NULL;
    }
}
