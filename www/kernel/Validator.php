<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validator
 *
 * @author Ruslan
 */
class Validator {
    private static $errors = [];
    private static $validators = [
        'required'      => 'requiredValue',
        'not_equal'     => 'notEqualValue',
        'equal'         => 'equalValue',
        'min'           => 'minValue',
        'max'           => 'maxValue',
        'alpha'         => 'alphaValue',
        'alpha_dotdash' => 'alphaDotDashValue',
        'alpha_special' => 'alphaSpecialValue',
        'numeric'       => 'numericValue',
        'alpha_numeric' => 'alphaNumericValue',
        'postcode'      => 'postcodeValue',
        'email'         => 'emailValue',
        'url'           => 'urlValue',
        'date'          => 'dateValue',
        'integer'       => 'intValue',
        'bool'          => 'boolValue',
        'in'            => 'equalValue',
    ];
    
    private static $validatorsMessages = [];

    public static function validateModel($object, $messages=[])
        {
        $validationArray = $object::$validators;
        
        foreach($validationArray as $validationArrayItem)
            {
            $validateFields = (array)array_shift($validationArrayItem);
            $functions = [];
            
            foreach ($validationArrayItem as $validationTypeKey => $validationTypeValue)
                {
                if(!is_integer($validationTypeKey))
                    {
                    if(isset(self::$validators[$validationTypeKey]))
                        {
                        $functions[self::$validators[$validationTypeKey]] = (array)$validationTypeValue;
                        }
                    }
                else 
                    {
                    if(isset(self::$validators[$validationTypeValue]))
                        {
                        $functions[self::$validators[$validationTypeValue]] = [];
                        }
                    }
                }
                
            if(!empty($validateFields) && !empty($functions))
                {
                foreach($validateFields as $validateField)
                    {
                    $field['name'] = $validateField;
                    $field['value'] = (isset($object->attributes[$validateField])) ? $object->attributes[$validateField] : null;
                    foreach($functions as $function => $args)
                        {
                        self::callValidatorFunction($function, $field, $args);
                        }
                    }
                }
            }
        
        if(empty(self::$errors))
            {
            return true;
            }
            
        return false;
        }
        
    public static function getErrors()
        {
        return self::$errors;
        }

    private static function callValidatorFunction($function, $field, $args=[])
        {
        forward_static_call(__CLASS__ . "::" . $function, $field, $args);
        }
        
    private static function error($field, $validationType, $message, $args=[])
        {
        if(!isset(self::$validatorsMessages[$validationType]))
            {
            self::$errors[$field][$validationType] = $message;
            return true;
            }
        
        $paramsStr = '';
        if($args)
            {
            $paramsStr = '"'.implode(', "', $args).'"';
            }
        self::$errors[$field][$validationType] = sprintf(self::$validatorsMessages[$validationType], $paramsStr);
        }
    
    private function setMessages($messages=[])
        {
        if(empty($messages))
            {
            return false;
            }
        self::$validatorsMessages = $messages;
        return true;
        }
        
        
    static function requiredValue($field, $args=[])
        {
        if (empty($field['value']))
            {
            self::error($field['name'], 'required', 'This field is required.');
            return false;
            }
        elseif (is_array($field['value']))
            {
            self::error($field['name'], 'required', 'This is an array and won\'t be passed.');
            return false;
            }
            
        return true;
        }
        
    static function notEqualValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
        
        foreach ($args as $arg)
            {
            if ($field['value'] == $arg)
                {
                self::error($field['name'], 'not_equal', 'You must select a different option other than "'.$arg.'"');
                return false;
                }
            }
        return true;
        }
        
    static function equalValue($field, $args=[])
        {
//        if(empty($field['value']))
//            {
//            return true;
//            }
            
        $equals = false;
        foreach ($args as $arg)
            {
            if ($field['value'] == $arg)
                {
                $equals = true;
                break;
                }
            }
            
        if(!$equals)
            {
            self::error($field['name'], 'equal', 'You must select a "'.implode(', "', $args).'"');
            return false;
            }
        return true;
        }
        
    static function minValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (strlen($field['value']) < (int) $args[0])
            {
            $msg = "This field cannot be shorter than {$args[0]} characters.";
            self::error($field['name'], 'min', $msg);
            return false;
            }
        return true;
        }
        
    static function maxValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (strlen($field['value']) > (int) $args[0])
            {
            $msg = "This field cannot be longer than {$args[0]} characters.";
            self::error($field['name'], 'max', $msg);
            return false;
            }
        return true;
        }
        
        
    static function alphaValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (!preg_match("/^([a-z])+$/i", $field['value']))
            {
            $msg = "This field can only contain letters (A-Z). No foreign characters allowed.";
            self::error($field['name'], 'alpha', $msg);
            return false;
            }
        return true;
        }
        
    static function alphaDotDashValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (!preg_match("/^([a-z\-\.])+$/i", $field['value']))
            {
            $msg = "This field can only contain characters (A-Z-.). No foreign characters allowed.";
            self::error($field['name'], 'alpha_dotdash', $msg); 
            return false;
            }
        return true;
        }
        
    static function alphaSpecialValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (!preg_match("/^([a-z0-9\-+\.,_='\"@#])+$/i", $field['value']))
            {
            $msg = "This field has illegal characters. You can use letters, numbers and (._-+='\"@#).";
            self::error($field['name'], 'alpha_special', $msg); 
            return false;
            }
        return true;
        }
        
    static function numericValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (!preg_match("/^[\-+]?[0-9]*\.?[0-9]+$/", $field['value']))
            {
            $msg = "This field must contain only numbers.";
            self::error($field['name'], 'numeric', $msg); 
            return false;
            }
        return true;
        }
        
    static function alphaNumericValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (!preg_match("/^([a-z0-9])+$/i", $field['value']))
            {
            $msg = "This field can only contain letters and numbers.";
            self::error($field['name'], 'alpha_numeric', $msg); 
            return false;
            }
        return true;
        }
        
    static function postcodeValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (!preg_match("/^[a-zA-Z]{1,3}[0-9]{1,3} [0-9]{1}[a-zA-Z]{2}$/i", $field['value']))
            {
            $msg = "Postcode must follow the format of \"XX1 1XX\".";
            self::error($field['name'], 'postcode', $msg); 
            return false;
            }
        return true;
        }
        
    static function urlValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $field['value']))
            {
            $msg = "Invalid URL";
            self::error($field['name'], 'url', $msg); 
            return false;
            }
        return true;
        }
        
    static function emailValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
        // Function from: http://www.ilovejackdaniels.com/php/email-address-validation/
        // Complies with the email address specification guidelines: RFC 2822
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/i", $field['value']))
          {
          // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
          $msg = "Your email address is not valid.";
          self::error($field['name'], 'email',  $msg);
          return false;
          }

        // Split it into sections to make life easier
        $email_array = explode("@", $field['value']);
        $local_array = explode(".", $email_array[0]);

//        for ($i = 0; $i < sizeof($local_array); $i++)
//          {
//          if (!preg_match("^(([A-Za-z0-9!#$%&amp;amp;amp;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&amp;amp;amp;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
//            {
//            $msg = "The first part of your email is malformed.";
//            self::error($field['name'], 'email', $msg);
//            return false;
//            }
//          }

        if (!preg_match("/^\[?[0-9\.]+\]?$/i", $email_array[1])) // Check if domain is IP. If not, it should be valid domain name
          {
          $domain_array = explode(".", $email_array[1]);
          if (sizeof($domain_array) < 2)
            {
            $msg = "Your email doesn't have a valid domain.";
            self::error($field['name'], 'email', $msg);
            return false; // Not enough parts to domain
            }

          for ($i = 0; $i < sizeof($domain_array); $i++)
            {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/i", $domain_array[$i]))
              {
              $msg = "Your email doesn't have a valid domain.";
              self::error($field['name'], 'email', $msg);
              return false;
              }
            }
          }

        // Check online to see if this is a real email host!
        if (isset($args[0]) && $args[0] == 'mx_records')
          {
          $host = $email_array[1]; //The whooole domain

          getmxrr($host, $mxhosts);
          if (count($mxhosts) < 1)
            {
            $msg = "There is no email host associated with your email. This probably means its fake.";
            self::error($field['name'], 'email', $msg);
            return false;
            }
          }
        return true;
        }
   
    static function dateValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
   
        $equals = false;
        
        if(empty($args))
            {
            $args[] = 'Y-m-d H:i:s';
            }
          
        foreach ($args as $arg)
            {
            $d = DateTime::createFromFormat($arg, $field['value']);
            
            if(($d && $d->format($arg) == $field['value']))
                {
                return true;
                }
            }

        self::error($field['name'], 'date', 'Wrong DateTime format. Value must be "'.implode(', "', $args).'" format');
        return false;
        }
        
    static function matchValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
        
        if(empty($args))
            {
            return true;
            }
          
        foreach ($args as $arg)
            {
            if (preg_match($arg, $field['value']))
                {
                return true;
                }
            }
            
        self::error($field['name'], 'date', 'Wrong DateTime format. Value must be "'.implode(', "', $args).'" format');
  
        return false;
        }
        
    static function intValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if(is_integer($field['value']))
            {
            return true;
            }
                   
        self::error($field['name'], 'integer', 'Wrong value type. '.$field['name']. ' must be integer');
  
        return false;
        }
        
    static function boolValue($field, $args=[])
        {
        if(empty($field['value']))
            {
            return true;
            }
            
        if(is_bool($field['value']))
            {
            return true;
            }
                   
        self::error($field['name'], 'bool', 'Wrong value type. '.$field['name']. ' must be boolean');
  
        return false;
        }
}
