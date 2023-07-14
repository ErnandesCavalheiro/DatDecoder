<?php

require 'src/File.php';

$files = $_FILES['files'];

for ($i = 0; $i < count($files['tmp_name']); $i++) {
    $fileModel = new File($files['tmp_name'][$i], $files['name'][$i]);

    try {
        var_dump($fileModel->store());
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
