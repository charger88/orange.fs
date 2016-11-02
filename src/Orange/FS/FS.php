<?php

namespace Orange\FS;

class FS {

	protected static $app_fs_root = '';

	public static function setRoot($app_fs_root){
		static::$app_fs_root = is_null($app_fs_root) ? '' : (rtrim($app_fs_root, '/') . '/');
	}

	public static function root(){
		return static::$app_fs_root;
	}

	public static function name($file_path){
		return strpos(static::root(), $file_path) === 0 ? $file_path : ( static::root() . $file_path );
	}

	public static function open($file_path){
		$file_path = strpos($file_path . '/', FS::root()) === 0 ? $file_path : ( FS::root() . $file_path );
		if (is_file($file_path)){
			return new File($file_path);
		} else if (is_dir($file_path)){
			return new Dir($file_path);
		} else {
			throw new FSException('File is not found.', $file_path);
		}
	}

}