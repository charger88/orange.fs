<?php

namespace Orange\FS;

interface FSObjectInterface {
	
	public function __construct($file_path, $filename = null);
	
	public function exists();
	
	public function cp($new_file_path);
	
	public function move($new_file_path);
	
	public function remove();
	
	public function getLocation();
	
	public function getName();
	
	public function getPath();
	
}