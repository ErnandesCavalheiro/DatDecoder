<?php

class Decoder
{
    public static function seller($phrase)
    {
        $array = explode('ç', $phrase);

        $array[0] = preg_replace('/\s+/', '', $array[0]);
        $array[2] = preg_replace('/\s+/', '', $array[2]);

        return [
            'cpf' => $array[0],
            'name' => $array[1],
            'salary' => $array[2]
        ];
    }

    public static function client($phrase)
    {
        $array = explode('ç', $phrase);

        $array[0] = preg_replace('/\s+/', '', $array[0]);
        $array[2] = preg_replace('/\s+/', '', $array[2]);

        return [
            'cnpj' => $array[0],
            'name' => $array[1],
            'lineOfBusiness' => $array[2]
        ];
    }

    public static function sale($phrase)
    {
        // Separa os elementos entre colchetes
        preg_match('/\[(.*?)\]/', $phrase, $bracketsMatches);
        $bracketsContent = $bracketsMatches[1];

        // Separa os elementos fora dos colchetes
        $outsideBrackets = explode('ç', preg_replace('/\[(.*?)\]/', '', $phrase));

        if ($outsideBrackets[2]) {
            $outsideBrackets[1] = $outsideBrackets[2];
            unset($outsideBrackets[2]);
        }

        // Separa os elementos dentro dos colchetes
        $insideBrackets = array_map('trim', explode(',', $bracketsContent));

        $list = [];

        foreach ($insideBrackets as $val) {
            $itemList = explode('-', $val);

            $itemList = array_map(function ($item) {
                return preg_replace('/\s+/', '', $item);
            }, $itemList);

            $list[] = [
                'itemId' => $itemList[0],
                'quantity' => $itemList[1],
                'price' => $itemList[2]
            ];
        }

        // Combina os elementos em um array final
        $result = [
            'sellerId' => trim($outsideBrackets[0]),
            'itemList' => $list,
            'sellerName' => trim($outsideBrackets[1])
        ];

        return $result;
    }
}
