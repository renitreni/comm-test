<?php
namespace App\Controller;

class ParseController
{
    public static function getData($filename)
    {
        $the_big_array = [];
        $raw_data      = fopen($filename, "r");
        while (($data = fgetcsv($raw_data, 1000, ",")) !== false) {
            $the_big_array[] = $data;
        }

        return $the_big_array;
    }
}