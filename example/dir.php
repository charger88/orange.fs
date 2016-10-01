<?php

require_once __DIR__ . '/_boot.php';

try {
    $dir = new \Orange\FS\Dir('subfolder/subsubfolder');
    $dir->create();
    for ($i = 1; $i <= 9; $i++) {
        $file = new \Orange\FS\File($dir, 'file-' . $i . '.txt');
        $file->save(str_repeat('[' . $i . ']', 20));
    }
    $files = $dir->readDir();
    foreach ($files as $file){
        $output = $file instanceof \Orange\FS\Dir ? 'DIR' : 'FILE';
        $output .= ': ' . $file->getPath();
        echo $output . "\n";
    }
    sleep(1);
    $dir->remove();
    \Orange\FS\FS::open('subfolder')->remove();
} catch (\Orange\FS\FSException $e){
    echo 'Exception: ' . $e->getMessage() . ' File: ' . $e->getFilepath();
}