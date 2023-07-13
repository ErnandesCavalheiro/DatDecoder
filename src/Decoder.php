<?php

require 'utils/StringFormat.php';

class Decoder
{
    public static function seller($phrase)
    {
        $keys = ['cpf', 'name', 'salary'];
        return StringFormat::parseFields($phrase, $keys);
    }

    public static function client($phrase)
    {
        $keys = ['cnpj', 'name', 'lineOfBusiness'];
        return StringFormat::parseFields($phrase, $keys);
    }

    public static function parseItemList($bracketsContent)
    {
        $insideBrackets = array_map('trim', explode(',', $bracketsContent));

        $list = [];
        $total = 0;
        foreach ($insideBrackets as $val) {
            $itemList = explode('-', $val);
            $itemList = array_map([StringFormat::class, 'cleanSpaces'], $itemList);

            $total += $itemList[2];

            $list[] = [
                'itemId' => $itemList[0],
                'quantity' => $itemList[1],
                'price' => $itemList[2]
            ];
        }

        $list['total'] = $total;

        return $list;
    }

    public static function sale($phrase)
    {
        preg_match('/\[(.*?)\]/', $phrase, $bracketsMatches);
        $bracketsContent = $bracketsMatches[1];

        $outsideBrackets = explode('ç', preg_replace('/\[(.*?)\]/', '', $phrase));

        if ($outsideBrackets[2]) {
            $outsideBrackets[1] = $outsideBrackets[2];
            unset($outsideBrackets[2]);
        }

        $result = [
            'saleId' => trim($outsideBrackets[0]),
            'itemList' => self::parseItemList($bracketsContent),
            'sellerName' => trim($outsideBrackets[1])
        ];

        return $result;
    }
}
