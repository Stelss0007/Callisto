<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Globals
{
    private static $vars = [];

    public static function getVar($var_name, $default_value = false)
    {
        if (isset(self::$vars[$var_name])) {
            return self::$vars[$var_name];
        }

        return $default_value;
    }

    public static function setVar($var_name, $value)
    {
        self::$vars[$var_name] = $value;

        return true;
    }
}

