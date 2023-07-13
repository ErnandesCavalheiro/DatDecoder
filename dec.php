<?php

require 'src/Decoder.php';

$listPhrases = [
    '001ç1234567891234çDiegoç50000',
    '001ç3245678865434çRenatoç40000. 99',
    '002ç2345675434544345çJose da SilvaçRural',
    '003ç10ç[1-10-100, 2-30-2. 50, 3-40-3. 10] çDiego',
    '003ç08ç[1-34-10, 2-33-1. 50, 3-40-0. 10] çRenato'
];

$json = [
    'seller' => [],
    'client' => [],
    'sale' => []
];

foreach ($listPhrases as $phrase) {
    $identifier = substr($phrase, 0, 3);
    $phraseWithoutId =  str_replace($identifier . 'ç', '', $phrase);

    switch ($identifier) {
        case '003':
            $res = Decoder::sale($phraseWithoutId);
            $json['sale'][] = $res; // Adicionar resultado ao array 'sale'
            break;
        case '002':
            $res = Decoder::client($phraseWithoutId);
            $json['client'][] = $res; // Adicionar resultado ao array 'client'
            break;
        case '001':
            $res = Decoder::seller($phraseWithoutId);
            $json['seller'][] = $res; // Adicionar resultado ao array 'seller'
            break;
        default:
            echo "Não encontrado!";
            break;
    }
}

echo json_encode($json);
