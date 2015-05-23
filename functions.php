<?php
	/**
	 * Create autoload
	 */
	spl_autoload_register('classLoad');
	function classLoad($className) {
		require_once(DIR_CLASSES. DS. $className. '.php');
	}
	/**
	 * Alias for calling modules methods in more comfort way
	 */
	function rs($callString) {
		$callArr = array_map('trim', explode('.', $callString));
		if(!empty($callArr)) {
			$callModule = frame::_()->getModule($callArr[0]);
			if($callModule) {
				if(isset($callArr[1])) {
					$callObject = NULL;
					$callMethod = '';
					switch(strtolower($callArr[1])) {
						case 'view':
							$callObject = $callModule->getController()->getView();
							$callMethod = isset($callArr[2]) ? $callArr[2] : false;
							break;
						case 'model':
							$callObject = $callModule->getController()->getModel();
							$callMethod = isset($callArr[2]) ? $callArr[2] : false;
							break;
						case 'controller':
							$callObject = $callModule->getController();
							$callMethod = isset($callArr[2]) ? $callArr[2] : false;
							break;
						default:
							$callObject = $callModule;
							$callMethod = $callArr[1];
							break;
					}
					if(!$callMethod)
						return $callObject;
					if(method_exists($callObject, $callMethod)) {
						$args = array();
						$numArgs = func_num_args();
						if($numArgs > 1) {
							for($i = 1; $i < $numArgs; $i++) {
								$args[] = func_get_arg($i);
							}
						}
						return call_user_func_array(array($callObject, $callMethod), $args);
					} else
						throw new Exception('Can\'t find method for "'. $callMethod.'" for class "'. get_class($callObject). '"');
				} else
					return $callModule;
			} else
				throw new Exception('Can\'t find anything for "'. $callString.'"');
		}
	}
	function redirect($url) {
		if(headers_sent()) {
			echo '<script type="text/javascript"> document.location.href = "'. $url. '"; </script>';
		} else {
			header('Location: '. $url);
		}
		exit();
	}