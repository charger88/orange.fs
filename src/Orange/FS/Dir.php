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
        $this->clear();
        $res = @rmdir($this->file_path);
        if (!$res){
            throw new FSException('Directory removing was failed.', $this->file_path);
        }
        return $this;
    }


    public function clear(){
        if (!$this->exists()) {
            throw new FSException('Directory does not exist.', $this->file_path);
        }
        $files = $this->readDir();
        foreach ($files as $file){
            $file->remove();
        }
        return $this;
    }

    public function getDirInfo(){
        $count = $size = 0;
        if (!$this->exists()) {
            throw new FSException('Directory does not exist.', $this->file_path);
        }
        $dirFiles = $this->readDir();
        foreach ($dirFiles as $file){
            if ($file instanceof Dir){
                list($fCount,$fSize) = $file->getDirInfo();
                $count += $fCount;
                $size += $fSize;
            } else {
                $count++;
                $size += $file->getFileSize();
            }
        }
        return array($count,$size);
    }
	
}