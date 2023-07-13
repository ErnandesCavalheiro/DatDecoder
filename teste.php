<?php

require 'src/File.php';

$arq = $_FILES['files'];

$file = new File($arq['tmp_name'], $arq['name']);

try {
    var_dump($file->store());
} catch (Exception $e) {
    die($e->getMessage());
}