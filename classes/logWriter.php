<?php
class logWriter {
	static public function write() {
		if(DB_LOG) {
			$logDb = new logDb();
			$logDb->write();
		}
	}
}