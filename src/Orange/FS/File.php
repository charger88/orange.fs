<?php

namespace Orange\FS;

class File extends FSObject implements FSObjectInterface
{

    protected $file_path;

    public function __construct($file_path, $filename = null)
    {
        if ($file_path instanceof Dir){
            $file_path = $file_path->getPath();
        }
        if (!is_null($filename)) {
            $file_path = rtrim($file_path, '/') . '/' . $filename;
        }
        $file_path = strpos($file_path, FS::root()) === 0 ? $file_path : ( FS::root() . $file_path );
        if (is_dir($file_path)) {
            throw new FSException('Object is directory (file expected).', $this->file_path);
        }
        $this->file_path = $file_path;
    }

    public function getData()
    {
        if (!$this->exists()) {
            throw new FSException('File does not exist.', $this->file_path);
        }
        return file_get_contents($this->file_path);
    }

    public function save($data, $add = false)
    {
        if (
            ($this->exists() && !is_writable($this->file_path)) ||
            (!$this->exists() && !is_writable($this->getLocation()))
        ) {
            throw new FSException('File is not writable.', $this->file_path);
        }
        $res = file_put_contents($this->file_path, $data, $add ? FILE_APPEND : 0);
        if ($res === false) {
            throw new FSException('File saving was failed.', $this->file_path);
        }
        return $this;
    }

    public function cp($new_file_path)
    {
        if (!$this->exists()) {
            throw new FSException('File does not exist.', $this->file_path);
        }
        if (!is_writable($new_file_path)) {
            throw new FSException('File is not writable.', $new_file_path);
        }
        copy($this->file_path, $new_file_path);
        return $this;
    }

    public function move($new_file_path)
    {
        if (!$this->exists()) {
            throw new FSException('File does not exist.', $this->file_path);
        }
        if (!is_writable($new_file_path)) {
            throw new FSException('File is not writable.', $new_file_path);
        }
        $this->cp($new_file_path);
        $this->remove();
        $this->file_path = $new_file_path;
        return $this;
    }

    public function remove()
    {
        if (!$this->exists()) {
            throw new FSException('File does not exist.', $this->file_path);
        }
        $res = @unlink($this->file_path);
        if ($res === false) {
            throw new FSException('File removing was failed.', $this->file_path);
        }
        return $this;
    }

    public function getLocation()
    {
        return dirname($this->file_path);
    }

    public function getName()
    {
        return basename($this->file_path);
    }

    public function getPath()
    {
        return $this->file_path;
    }

}