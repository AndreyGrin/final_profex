<?php
class uri {
	static public function getLink($path = '', $params = array()) {
		$url = URL_ROOT. '/'. $path;
		if($params) {
			$url .= '?'. http_build_query($params);
		}
		return $url;
	}
	static public function getAdminLink($path = '', $params = array()) {
		$path = ADMIN_ALIAS. '/'. $path;
		return self::getLink($path, $params);
	}
	static public function getCurrent() {
		return URL_ROOT. $_SERVER['REQUEST_URI'];
	}
}