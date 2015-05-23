<?php
abstract class view extends baseMvc {
	public function assign($key, $val) {
		$this->$key = $val;
	}
	public function getContent($tpl) {
		$fullTplPath = document::_()->getTemplatesDir(). DS. $this->getCode(). DS. $tpl. '.php';
		if(file_exists($fullTplPath)) {
            ob_start();
            require($fullTplPath);
            $content = ob_get_contents();
            ob_end_clean();
			return $content;
		} else
			throw new Exception('Can\'t find template file '. $tpl. ' for view '. $this->getCode());
	}
}