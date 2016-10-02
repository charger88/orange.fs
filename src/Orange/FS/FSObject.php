<?php

namespace Orange\FS;

abstract class FSObject {
	
	protected $file_path;
	
	abstract public function __construct($file_path, $filename = null);

    public function exists(){
        return file_exists($this->file_path);
    }
	
	public function cp($new_file_path){
		if (!$this->exists()){
			throw new FSException('File does not exist.', $this->file_path);
		}
		if (!is_writable($new_file_path)){
			throw new FSException('File is not writable.', $new_file_path);
		}
		copy($this->file_path, $new_file_path);
		return $this;
	}
	
	public function move($new_file_path){
		if (!$this->exists()){
			throw new FSException('File does not exist.', $this->file_path);
		}
		if (!is_writable($new_file_path)){
			throw new FSException('File is not writable.', $new_file_path);
		}
        $this->cp($new_file_path);
        $this->remove();
        $this->file_path = $new_file_path;
		return $this;
	}

	abstract public function remove();

	public function getLocation(){
		return dirname($this->file_path);
	}
	
	public function getName(){
		return basename($this->file_path);
	}
	
	public function getPath(){
		return $this->file_path;
	}

    public function getModifyTime(){
        if (!$this->exists()){
            throw new FSException('File (directory) does not exist.', $this->file_path);
        }
        return filemtime($this->file_path);
    }

}