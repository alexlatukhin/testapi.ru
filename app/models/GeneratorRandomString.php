<?php

namespace app\models;


class GeneratorRandomString
{
    /**
     * @return false|string
     */
    public static function create ()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = substr(str_shuffle($permitted_chars), 0, 20);
        return $str;
    }
}