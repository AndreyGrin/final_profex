<?php
class logDb extends log {
	public function write() {
		$logData = array();
		$queries = db::_()->getQueries();
		$logData[] = 'Time: '. date('d-m-Y H:i:s');
		$logData[] = 'Request: '. $_SERVER['REQUEST_URI'];
		$logData[] = 'Total queries: '. count($queries);
		foreach($queries as $q) {
			$logData[] = '';
			$logData[] = $q['query'];
			$logData[] = $q['time'];
		}
		$fileName = str_replace('.', '_', HOST). '_'. date('d_m_Y_H_i_s'). '.log';
		file_put_contents(DIR_LOG. DS. $fileName, implode(PHP_EOL, $logData));
	}
}