<?php

require_once __DIR__ . '/Decoder.php';
require_once __DIR__ . '/File.php';
require_once __DIR__ . '/AnalyzeData.php';

class FileWatcher
{
    private $pathIn = __DIR__ . '/../data/in';
    private $numFiles = 0;

    public static function fileProccess($file)
    {
        $contents = file($file, FILE_IGNORE_NEW_LINES);

        $data = [
            'sale' => [],
            'client' => [],
            'seller' => []
        ];

        foreach ($contents as $content) {
            $identifier = substr($content, 0, 3);
            $lineContent =  str_replace($identifier . 'ç', '', $content);

            switch ($identifier) {
                case '003':
                    $res = Decoder::sale($lineContent);
                    $data['sale'][] = $res; // Adicionar resultado ao array 'sale'
                    break;
                case '002':
                    $res = Decoder::client($lineContent);
                    $data['client'][] = $res; // Adicionar resultado ao array 'client'
                    break;
                case '001':
                    $res = Decoder::seller($lineContent);
                    $data['seller'][] = $res; // Adicionar resultado ao array 'seller'
                    break;
                default:
                    echo "Não encontrado!";
                    break;
            }
        }

        return $data;
    }

    public function watchDir()
    {
        while (true) {
            $files = glob($this->pathIn . '/*.dat');
            $count = count($files);

            if ($this->numFiles === $count) {
                continue;
            }

            $this->numFiles = $count;

            if (!empty($files)) {
                $array = [
                    'seller' => [],
                    'client' => [],
                    'sale' => []
                ];

                foreach ($files as $file) {
                    $newData = $this::fileProccess($file);

                    $array['seller'][] = $newData['seller'];
                    $array['client'][] = $newData['client'];
                    $array['sale'][] = $newData['sale'];
                }
            }

            $highestSale = AnalyzeData::findHighestTotalSale($array);
            $totalClients = AnalyzeData::countClients($array);
            $totalSellers = AnalyzeData::countSellers($array);
            $worstSeller = AnalyzeData::worstSeller($array);

            $lines = [
                'Total de clientes: '.$totalClients,
                'Total de vendedores: '.$totalSellers,
                'Id da maior venda: '.$highestSale['saleId'],
                'Nome do pior vendedor: '.$worstSeller
            ];

            (new File('', ''))->createAndWriteDatFile('relatorio.done', $lines);
            
            sleep(10);
        }
    }
}
