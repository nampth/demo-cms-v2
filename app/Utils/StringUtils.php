<?php
/**
 * Created by PhpStorm.
 * User: Nampth
 * Date: 3/18/2021
 * Time: 10:07 AM
 */

namespace App\Utils;


class StringUtils
{

    public static function validate_input($str)
    {
        return strip_tags(trim($str));
    }

    public static function random_string($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function query_to_sql($sql)
    {
        try {
            $arrBindings = $sql->getBindings();
            foreach ($arrBindings as $ind => $arrBinding) {
                $arrBindings[$ind] = "$arrBinding";
            }
            $formatSql = str_replace('?', '"%s"', $sql->toSql());
            $formatSql = vsprintf($formatSql, $arrBindings);
            return $formatSql;
        } catch (\Exception $e) {
            return 'error ' . $e->getMessage();
        }
    }
}