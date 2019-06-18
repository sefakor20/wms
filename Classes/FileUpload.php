<?php
/**

*/
class FileUpload
{
	protected $file;

	protected $directory;
	
	public function __construct($name, $destinationDir = './')
	{
		if(!empty($_FILES[$name])) {
			$this->file = $_FILES[$name];
		} else {
			$this->file = [];
		}
		$this->directory = $destinationDir;
	}


	//check if file was uploaded successfully and no error occured
	public function isValid() {
		return $this->file['error'] === UPLOAD_ERR_OK;
	}


	public function getError() {
		$error = $this->file['error'] ?: UPLOAD_ERR_NO_FILE;

		switch ($error) {
			case UPLOAD_ERR_INI_SIZE:
				$message = 'file size exceeds maximum size permited';
				break;

			case UPLOAD_ERR_FORM_SIZE:
				$message = 'file exceeds max file directory';
				break;

			case UPLOAD_ERR_PARTIAL:
				$message= 'file only partially uploaded';
				break;

			case UPLOAD_ERR_NO_TMP_DIR:
				$message = 'missing a temporary folder';
				break;

			case UPLOAD_ERR_CANT_WRITE:
				$message = 'failed to write file to disk';
				break;

			case UPLOAD_ERR_EXTENSION:
				$message = 'file upload stopped by extension';
				break;
			
			default:
				$message = 'unknown upload error';
				break;
		}
	}


	//move uploaded file to directory
	public function move($name = null) {
		if(!$this->isValid()) {
			return;
		}
		//user origanl file name if none is given
		if(empty($name)) {
			$name = $this->file['name'];
		}
		move_uploaded_file($this->file['tmp_name'], $this->directory.$name);
	}


	//get file name for database
	public function getFileName() {
		return $this->file['name'];
	}


	//get file size
	public function getFileSize() {
		return $this->file['size'];
	}
}

?>