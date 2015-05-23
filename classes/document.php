<?php
class document {
	private $_scripts = array();
	private $_coreScripts = array();
	private $_jsVars = array();
	private $_styles = array();
	private $_content = '';
	private $_mainFile = '';
	private $_footerFile = '';
	private $_title = '';
	
	static public function getInstance() {
		static $instance;
		if(!$instance) {
			$instance = new document();
		}
		return $instance;
	}
	static public function _() {
		return self::getInstance();
	}
	public function setContent($content) {
		$this->_content = $content;
	}
	public function getContent() {
		return $this->_content;
	}
	public function getTemplatesDir() {
		return DIR_TEMPLATE. DS. STANDARD;
	}
	public function getTemplatesUrl() {
		return URL_TEMPLATES. '/'. STANDARD;
	}
	public function assign($key, $val) {
		$this->$key = $val;
	}
	public function getMainFile() {
		if(empty($this->_mainFile)) {
			if(router::_()->isAdmin()) {
				$this->_mainFile = 'admin.index';
			} elseif(frame::_()->is404()) {
				$this->_mainFile = '404';
			} elseif(frame::_()->isHome()) {
				$this->_mainFile = 'home';
				$this->_footerFile = 'footer';
			} else {
				$this->_mainFile = 'index';
				$this->_footerFile = 'footer';
			}
		}
		return $this->_mainFile;
	}
	public function getFooterFile() {
		if(empty($this->_footerFile)) {
			if(router::_()->isAdmin()) {
				$this->_footerFile = 'admin.footer';
			} elseif(frame::_()->isHome()) {
				$this->_footerFile = 'footer';
			} else {
				$this->_footerFile = 'footer';
			}
		}
		return $this->_footerFile;
	}
	public function getFooter($tplDir) {
		$footerFile = $this->getFooterFile();
		if(!empty($footerFile)) {
			$footerFullPath = $tplDir. DS. $footerFile. '.php';
			if(file_exists($footerFullPath)) {
				ob_start();
				require($footerFullPath);
				$content = ob_get_contents();
				ob_end_clean();
				return $content;
			}
		}
		return '';
	}
	public function setMainFile($mainFile) {
		$this->_mainFile = $mainFile;
	}
	private function _connectTplPreload($tplDir) {
		$preloadFilePath = $tplDir. DS. 'preload.php';
		if(file_exists($preloadFilePath)) {
			require_once($preloadFilePath);
		}
	}
	public function display() {
		$tplDir = $this->getTemplatesDir();
		if(is_dir($tplDir)) {
			$mainFile = $this->getMainFile();
			$footer = $this->getFooter($tplDir);
			$this->_loadWidgetAssets();
			$this->_connectTplPreload($tplDir);
			$this->assign('scripts', $this->getCompiledScripts());
			$this->assign('styles', $this->getCompiledStyles());
			$this->assign('content', $this->getContent());
			$this->assign('title', $this->getTitle());
			$this->assign('footer', $footer);
			require_once($tplDir. DS. $mainFile. '.php');
		} else
			throw new Exception ('There are no templates directory for you');
	}
	private function _loadWidgetAssets() {
		$widgets = frame::_()->getModulesList(WIDGET);
		if(!empty($widgets)) {
			foreach($widgets as $w) {
				if($w->visible()) {
					$w->loadAssets();
				}
			}
		}
	}
	public function addScript($file, $path = '', $core = false) {
		if(!isset($this->_scripts[ $file ])) {
			if($core) 
				$this->_coreScripts[ $file ] = array('file' => $file, 'path' => $path);
			else
				$this->_scripts[ $file ] = array('file' => $file, 'path' => $path);
		}
	}
	public function addCoreScript($file, $path = '') {
		$this->addScript($file, $path, true);
	}
	public function addJsVar($name, $val) {
		$this->_jsVars[ $name ] = $val;
	}
	public function addStyle($file, $path = '') {
		if(!isset($this->_styles[ $file ])) {
			$this->_styles[ $file ] = array('file' => $file, 'path' => $path);
		}
	}
	public function getCompiledScripts() {
		$eol = PHP_EOL;
		$res = '';
		/*Retrive all JS variables at first*/
		if(!empty($this->_jsVars)) {
			$varsStrings = array();
			$varsStrings[] = '<script type="text/javascript">';
			$varsStrings[] = '/* <![CDATA[ */';
			foreach($this->_jsVars as $name => $val) {
				$varsStrings[] = 'var '. $name. ' = '. json_encode($val). ';';
			}
			$varsStrings[] = '/* ]]> */';
			$varsStrings[] = '</script>';
			$res .= implode($eol, $varsStrings);;
		}
		/*Now - get all scripts, load core scripts at first*/
		$allScripts = array_merge($this->_coreScripts, $this->_scripts);
		if(!empty($allScripts)) {
			$scriptsStrings = array();
			foreach($allScripts as $s) {
				if(isset($s['path']) && !empty($s['path'])) {
					$scriptsStrings[] = '<script type="text/javascript" src="'. $s['path']. '"></script>';
				} elseif(file_exists(DIR_JS. DS. $s['file']. '.js')) {
					$scriptsStrings[] = '<script type="text/javascript" src="'. URL_JS. '/'. $s['file']. '.js'. '"></script>';
				}
			}
			if(!empty($scriptsStrings))
				$res .= implode($eol, $scriptsStrings);
		}
		return $res;
	}
	public function getCompiledStyles() {
		$res = '';
		if(!empty($this->_styles)) {
			$stylesStrings = array();
			foreach($this->_styles as $s) {
				if(isset($s['path']) && !empty($s['path'])) {
					$stylesStrings[] = '<link type="text/css" rel="stylesheet" href="'. $s['path']. '" />';
				} elseif(file_exists(DIR_CSS. DS. $s['file']. '.css')) {
					$stylesStrings[] = '<link type="text/css" rel="stylesheet" href="'. URL_CSS. '/'. $s['file']. '.css'. '" />';
				}
			}
			$res = implode(PHP_EOL, $stylesStrings);
		}
		return $res;
	}
	public function setTitle($title) {
		$this->_title = $title;
	}
	public function getTitle() {
		return $this->_title;
	}
	public function connectJqueryUi() {
		$this->addScript('jquery-ui', URL_JS. '/jquery-ui.min.js');
		$this->addStyle('jquery-ui', URL_CSS. '/jquery-ui.min.css');
		$this->addStyle('jquery-ui.structure', URL_CSS. '/jquery-ui.structure.min.css');
		$this->addStyle('jquery-ui.theme', URL_CSS. '/jquery-ui.theme.min.css');
	}
}