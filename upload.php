<?php

require 'src/File.php';

$files = $_FILES['files'];

for ($i = 0; $i < count($files['tmp_name']); $i++) {
    $fileModel = new File($files['tmp_name'][$i], $files['name'][$i]);

    try {
        $fileModel->store();

        $count = $i + 1;

        echo "Arquivo $i enviado com sucesso!";
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
