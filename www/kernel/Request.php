<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author Ruslan
 */
class Request {
    
    public static function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getPostParam($field = false) {
        if(!$fields) return null;
        
        if(isset($_POST[$field])) {
            return $_POST[$field];
        }
         
    }
    public static function getPostParams($fields = false){
        if(!$fields){
            return $_POST;
        }
        
        if(!is_array($fields)) {
            return self::getPostParam($fields);
        }
        
        $result = [];
        
        foreach($fields as $field) {
            $result[$field] = self::getPostParam($field);
        }
        
        return $result;
    }
}
