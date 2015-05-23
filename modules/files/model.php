<?php
class filesModel extends model {
	private $_supportedMimeTypes = array(	// Only images for now
		'images' => array(
			'image/gif',
			'image/jpeg',
			'image/pjpeg',
			'image/png',
			'image/svg+xml',
			'image/tiff',
			'image/vnd.microsoft.icon',
			'image/vnd.wap.wbmp',
		),
	);
	public function __construct($code) {
		parent::__construct($code);
		$this->_setTbl('files');
	}
	public function saveFileFromRequest() {
		if (!empty($_FILES['fd-file']) && is_uploaded_file($_FILES['fd-file']['tmp_name'])) {
			// Regular multipart/form-data upload.
			$name = $_FILES['fd-file']['name'];
			$filePath = $_FILES['fd-file']['tmp_name'];
			$mimeType = $this->getMimeType($filePath);
		} else {
			// Raw POST data.
			$name = urldecode(@$_SERVER['HTTP_X_FILE_NAME']);
			$filePath = RAW_POST_DATA;
			$mimeType = urldecode(@$_SERVER['HTTP_X_FILE_TYPE']);;
		}
		if(!empty($name) && !empty($filePath)) {
			return $this->saveFile($name, $filePath, $mimeType);
		} else
			$this->pushError (lang::_('EMPTY_FILE'));
	}
	public function saveFile($name, $filePath, $mimeType = '') {
		$uploadsDir = $this->getUploadsDir();
		if($uploadsDir) {
			if(empty($mimeType))
				$mimeType = $this->getMimeType($filePath);
			if($this->isMimeSupported($mimeType)) {
				$alias = $this->createFileAlias($name, $uploadsDir);
				$newPath = $uploadsDir. DS. $alias;
				if($this->moveUploadedFile($filePath, $newPath)) {
					$dbData = array(
						'name' => $name,
						'alias' => $alias,
						'mime_type' => $mimeType,
						'size' => $this->getFileSize($newPath),
					);
					if(db::_()->query('INSERT INTO `'. $this->_tbl.'` SET '. db::_()->toQuery($dbData, ','))) {
						$dbData['id'] = db::_()->getLastId();
						return $dbData;
					} else
						$this->pushError(db::_()->getLastError());
				} else
					$this->pushError(lang::_('CAN_NOT_MOVE_UPLOADED_FILE'));
			} else
				$this->pushError(sprintf(lang::_('FILE_TYPE_IS_NOT_SUPPORTED'), $mimeType));
		}
		return false;
	}
	public function moveUploadedFile($filePath, $to) {
		if($filePath == RAW_POST_DATA) {
			return file_put_contents($to, file_get_contents($filePath));
		} else {
			return move_uploaded_file($filePath, $to);
		}
	}
	public function getFileSize($filePath) {
		return filesize($filePath);
	}
	public function getMimeType($path) {
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $path);
		finfo_close($finfo);
		return $mime;
	}
	public function isMimeSupported($mime) {
		if(!empty($mime)) {
			foreach($this->_supportedMimeTypes as $types) {
				if(in_array($mime, $types))
					return true;
			}
		}
		return false;
	}
	public function validate($path) {
		
	}
	public function getUploadsDir() {
		$uploadsDir = DIR_ROOT. DS. UPLOADS;
		if(!is_dir($uploadsDir)) {
			if(!@mkdir($uploadsDir)) {
				$this->pushError(sprintf(lang::_('FAILED_CREATE_UPLOADS_DIR'), $uploadsDir));
				$uploadsDir = false;
			}
		}
		return $uploadsDir;
	}
	public function getUploadsUrl() {
		return URL_ROOT. '/'. UPLOADS;
	}
	public function createFileAlias($name, $uploadsDir = '', $sufix = 0) {
		if(!$uploadsDir)
			$uploadsDir = $this->getUploadsDir();
		if($uploadsDir) {
			$fileNameExt = explode('.', $name);
			if(!isset($fileNameExt[1]))	// For case when file does not have any extension in it's name
				$fileNameExt[1] = '';
			if(count($fileNameExt) > 2) {	// For case when file have more then one "." in it's name
				$fileNameMin = $fileNameExt;
				unset($fileNameMin[ count($fileNameMin)-1 ]);
				$fileNameExt = array(
					implode('.', $fileNameMin), $fileNameExt[ count($fileNameExt)-1 ]
				);
			}
			$alias = $fileNameExt[0]. (empty($sufix) ? '' : '-'. $sufix). '.'. $fileNameExt[1];
			if(file_exists($uploadsDir. DS. $alias)) {
				return $this->createFileAlias($name, $uploadsDir, ++$sufix);
			}
			return $alias;
		}
		return false;
	}
	public function getDataById($fid) {
		return db::_()->get('SELECT * FROM `'. $this->_tbl. '`', ROW, array('id' => $fid));
	}
	public function removeDataById($fid) {
		return db::_()->query('DELETE FROM `'. $this->_tbl. '` WHERE '. db::_()->toQuery(array('id' => $fid), 'AND'));
	}
	public function unlinkFile($alias) {
		if(@unlink($this->getUploadsDir(). DS. $alias)) {
			return true;
		}
		return false;
	}
	public function remove($fid) {
		$fileData = $this->getDataById($fid);
		if($fileData) {
			$this->removeDataById($fid);
			if($this->unlinkFile($fileData['alias'])) {
				return true;
			} else
				$this->pushError(lang::_('CAN_NOT_REMOVE_FILE'));
		} else 
			$this->pushError(lang::_('CAN_NOT_FIND_FILE'));
		return false;
	}
}