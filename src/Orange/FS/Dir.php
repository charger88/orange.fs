<?php

namespace Orange\FS;

class Dir extends FSObject implements FSObjectInterface {

	public function __construct($file_path, $filename = null){
        $file_path = rtrim($file_path, '/');
        if (!is_null($filename)){
			$file_path = $file_path . '/' . $filename;
		}
        $file_path = strpos($file_path . '/', FS::root()) === 0 ? $file_path : ( FS::root() . $file_path );
		if (is_file($file_path)){
			throw new FSException('Object is file (directory expected).', $this->file_path);
		}
		$this->file_path = $file_path;
	}

    public function readDir(){
        if (!$this->exists()) {
            throw new FSException('Directory does not exist.', $this->file_path);
        }
        $result = [];
        $dir = opendir($this->file_path);
        while ($f = readdir($dir)){
            if (strlen(trim($f, '.')) != 0) {
                $result[] = FS::open($this->file_path . '/' . $f);
            }
        }
        return $result;
    }

    public function create(){
        if ($this->exists()){
            throw new FSException('Directory already exists.', $this->file_path);
        }
        $location = new Dir($this->getLocation());
        if (!$location->exists()){
            $location->create();
        }
        $res = @mkdir($this->file_path);
        if (!$res){
            throw new FSException('Directory making was failed.', $this->file_path);
        }
        return $this;
    }

    public function remove(){
        if (!$this->exists()) {
            throw new FSException('Directory does not exist.', $this->file_path);
        }
        $files = $this->readDir();
        foreach ($files as $file){
            $file->remove();
        }
        $res = @rmdir($this->file_path);
        if (!$res){
            throw new FSException('Directory removing was failed.', $this->file_path);
        }
        return $this;
    }
	
}