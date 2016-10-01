<?php

namespace Orange\FS;

class FSException extends \Exception {
	
	protected $file_path;
	
	public function __construct($message = null, $file_path = null, $code = null, $previous = null){
		parent::__construct($message, $code, $previous);
		$this->file_path = $file_path;
	}
	
	public function getFilepath(){
		return $this->file_path;
	}
	
}