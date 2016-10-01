<?php

require_once __DIR__ . '/_boot.php';

try {
    $file = new \Orange\FS\File('io-test.txt');
    $file->save('My file content');
    echo $file->getData();
} catch (\Orange\FS\FSException $e){
    echo 'Exception: ' . $e->getMessage() . ' File: ' . $e->getFilepath();
}