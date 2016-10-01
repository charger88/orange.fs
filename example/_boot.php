<?php

require_once __DIR__ . '/../src/Orange/FS/FS.php';
require_once __DIR__ . '/../src/Orange/FS/FSException.php';
require_once __DIR__ . '/../src/Orange/FS/FSObjectInterface.php';
require_once __DIR__ . '/../src/Orange/FS/FSObject.php';
require_once __DIR__ . '/../src/Orange/FS/File.php';
require_once __DIR__ . '/../src/Orange/FS/Dir.php';

\Orange\FS\FS::setRoot(__DIR__);
$dir = new \Orange\FS\Dir('files');
if (!$dir->exists()) {
	$dir->create();
}
\Orange\FS\FS::setRoot(__DIR__ . '/files');