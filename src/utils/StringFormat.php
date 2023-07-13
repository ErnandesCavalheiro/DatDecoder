<?php

class StringFormat
{
    public static function parseFields($phrase, $keys)
    {
        $array = explode('ç', $phrase);

        $result = [];
        foreach ($keys as $index => $key) {
            if ($key == 'name') {
                $value = $array[$index] ?? '';
                $result[$key] = $value;
                continue;
            }
            $value = $array[$index] ?? '';
            $result[$key] = self::cleanSpaces($value);
        }

        return $result;
    }

    public static function cleanSpaces($str)
    {
        return preg_replace('/\s+/', '', $str);
    }
}
