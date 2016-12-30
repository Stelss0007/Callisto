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

/*
 *  $testArray = [
        'firstName' => 'ru',
        'secondName' => 'rus',
        'birthday' => '2016-10-20',
        'cardNumber' => '5211537422805189',
    ];  
    
    $validationRules = [
        'firstName'=> ['max'=>40, 'min'=>3, 'required'],
        'secondName'=> 'required',
        'birthday'=> ['required', 'date'=>'Y-m-d'],
        'cardNumber' => ['creditCard'],
    ];
    
    $validator  = \Validator::make($testArray, $validationRules);  
    appDebug($validator->hasError());  
    appDebug($validator->getErrors());  
    appDebug($validator->getFirstError('firstName'));
 */
class Validator {
    private static $errors = [];
    private static $validators = [
        'required'      => 'requiredValue',
        'notEqual'      => 'notEqualValue',
        'equal'         => 'equalValue',
        'min'           => 'minValue',
        'max'           => 'maxValue',
        'alpha'         => 'alphaValue',
        'alphaDotDash'  => 'alphaDotDashValue',
        'alphaSpecial'  => 'alphaSpecialValue',
        'numeric'       => 'numericValue',
        'alphaNumeric'  => 'alphaNumericValue',
        'postcode'      => 'postcodeValue',
        'email'         => 'emailValue',
        'url'           => 'urlValue',
        'date'          => 'dateValue',
        'integer'       => 'intValue',
        'bool'          => 'boolValue',
        'in'            => 'equalValue',
        'ip'            => 'ipValue',
        'creditCard'    => 'creditCardValue',
        'regex'         => ''
    ];
    
    private static $validatorsMessages = [];
    
    public static function make($fields, $rules)
    {
        $validator = new self;
        
        foreach($rules as $fieldName => $rules) {
            $field['name'] = $fieldName;
            $field['value'] = (isset($fields[$fieldName])) ? $fields[$fieldName] : null;
            
            $rules = (array)$rules;
            $functions = [];
          
            foreach($rules as $validationTypeKey => $validationTypeValue) {
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
            
            foreach($functions as $function => $args)
                {
                $validator->callValidatorFunction($function, $field, $args);
                }
        }
        return $validator;
    }

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
     
    public static function hasError($fieldName=null)
        {
        if(isset($this))
          {
            if($fieldName) {
                return isset($this->errors[$fieldName]);
            }  
          return !!$this->errors;
          } 
        else 
          {
            if($fieldName) {
                return isset(self::$errors[$fieldName]);
            }  
          return !!self::$errors;
          }
            
        }
        
    public static function getFirstError($fieldName=null)
        {
        if(isset($this))
          {
            if($fieldName) {
                return isset($this->errors[$fieldName]) ? array_values($this->errors[$fieldName])[0] : '';
            }  
          return '';
          } 
        else 
          {
            if($fieldName) {
                return isset(self::$errors[$fieldName]) ? array_values(self::$errors[$fieldName])[0] : '';
            }  
          return '';
          }
            
        }
    
        
    public static function getErrors($fieldName=null)
        {
        if(isset($this))
          {
            if($fieldName) {
                return isset($this->errors[$fieldName]) ? $this->errors[$fieldName] : [];
            }  
          return $this->errors;
          } 
        else 
          {
            if($fieldName) {
                return isset(self::$errors[$fieldName]) ? self::$errors[$fieldName] : [];
            }  
          return self::$errors;
          }
            
        }

    private static function callValidatorFunction($function, $field, $args=[])
        {
        forward_static_call(__CLASS__ . "::" . $function, $field, $args);
        }
        
    private static function setError($field, $validationType, $message, $args=[])
        {
        if(!isset(self::$validatorsMessages[$validationType]))
            {
            if(isset($this)){
                echo '3333';
                $this->errors[$field][$validationType] = $message;
            } else {
                self::$errors[$field][$validationType] = $message;
            }
            return true;
            }
        
        $paramsStr = '';
        if($args)
            {
            $paramsStr = '"'.implode(', "', $args).'"';
            }
         if(isset($this))   
             $this->errors[$field][$validationType] = sprintf($this->validatorsMessages[$validationType], $paramsStr);
         else
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
        
    static function regexValue($field, $args)
    {
        if(!preg_match($args[0], $field['value'])){
            self::setError($field['name'], 'regex', 'Not valid field "'.$args[0].'".');
            return false;
        }
        return true;
    } 
        
    static function requiredValue($field, $args=[])
        {
        if (empty($field['value']))
            {
            self::setError($field['name'], 'required', 'This field is required.');
            return false;
            }
        elseif (is_array($field['value']))
            {
            self::setError($field['name'], 'required', 'This is an array and won\'t be passed.');
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
                self::setError($field['name'], 'not_equal', 'You must select a different option other than "'.$arg.'"');
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
            self::setError($field['name'], 'equal', 'You must select a "'.implode(', "', $args).'"');
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
            self::setError($field['name'], 'min', $msg);
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
            self::setError($field['name'], 'max', $msg);
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
            self::setError($field['name'], 'alpha', $msg);
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
            self::setError($field['name'], 'alpha_dotdash', $msg); 
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
            self::setError($field['name'], 'alpha_special', $msg); 
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
            self::setError($field['name'], 'numeric', $msg); 
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
            self::setError($field['name'], 'alpha_numeric', $msg); 
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
            self::setError($field['name'], 'postcode', $msg); 
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
            self::setError($field['name'], 'url', $msg); 
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
          self::setError($field['name'], 'email',  $msg);
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
            self::setError($field['name'], 'email', $msg);
            return false; // Not enough parts to domain
            }

          for ($i = 0; $i < sizeof($domain_array); $i++)
            {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/i", $domain_array[$i]))
              {
              $msg = "Your email doesn't have a valid domain.";
              self::setError($field['name'], 'email', $msg);
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
            self::setError($field['name'], 'email', $msg);
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

        self::setError($field['name'], 'date', 'Wrong DateTime format. Value must be "'.implode(', "', $args).'" format');
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
            
        self::setError($field['name'], 'date', 'Wrong DateTime format. Value must be "'.implode(', "', $args).'" format');
  
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
                   
        self::setError($field['name'], 'integer', 'Wrong value type. '.$field['name']. ' must be integer');
  
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
                   
        self::setError($field['name'], 'bool', 'Wrong value type. '.$field['name']. ' must be boolean');
  
        return false;
        }
        
    static function ipValue($field, $args)
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
            if (filter_var($value, \FILTER_VALIDATE_IP) !== false)
                {
                return true;
                }
            }
            
        self::setError($field['name'], 'ip', 'Wrong IP format.');
  
        return false;
    }
    
    static function creditCardValue($field, $params)
    {
        $value = $field['value'];
        /**
         * I there has been an array of valid cards supplied, or the name of the users card
         * or the name and an array of valid cards
         */
        if (!empty($params)) {
            /**
             * array of valid cards
             */
            if (is_array($params[0])) {
                $cards = $params[0];
            } elseif (is_string($params[0])) {
                $cardType  = $params[0];
                if (isset($params[1]) && is_array($params[1])) {
                    $cards = $params[1];
                    if (!in_array($cardType, $cards)) {
                        return false;
                    }
                }
            }
        }

        
        /**
         * Luhn algorithm
         *
         * @return bool
         */
        $numberIsValid = function () use ($value) {
            $number = preg_replace('/[^0-9]+/', '', $value);
            $sum = 0;
            $strlen = strlen($number);
            if ($strlen < 13) {
                return false;
            }
            for ($i = 0; $i < $strlen; $i++) {
                $digit = (int) substr($number, $strlen - $i - 1, 1);
                if ($i % 2 == 1) {
                    $sub_total = $digit * 2;
                    if ($sub_total > 9) {
                        $sub_total = ($sub_total - 10) + 1;
                    }
                } else {
                    $sub_total = $digit;
                }
                $sum += $sub_total;
            }
            if ($sum > 0 && $sum % 10 == 0) {
                    return true;
            }
            return false;
        };
        
        if ($numberIsValid()) {
            if (!isset($cards)) {
                return true;
            } else {
                $cardRegex = array(
                    'visa'          => '#^4[0-9]{12}(?:[0-9]{3})?$#',
                    'mastercard'    => '#^5[1-5][0-9]{14}$#',
                    'amex'          => '#^3[47][0-9]{13}$#',
                    'dinersclub'    => '#^3(?:0[0-5]|[68][0-9])[0-9]{11}$#',
                    'discover'      => '#^6(?:011|5[0-9]{2})[0-9]{12}$#',
                );
                if (isset($cardType)) {
                    // if we don't have any valid cards specified and the card we've been given isn't in our regex array
                    if (!isset($cards) && !in_array($cardType, array_keys($cardRegex))) {
                        return false;
                    }
                    // we only need to test against one card type
                    return (preg_match($cardRegex[$cardType], $value) === 1);
                } elseif (isset($cards)) {
                    // if we have cards, check our users card against only the ones we have
                    foreach ($cards as $card) {
                        if (in_array($card, array_keys($cardRegex))) {
                            // if the card is valid, we want to stop looping
                            if (preg_match($cardRegex[$card], $value) === 1) {
                                return true;
                            }
                        }
                    }
                } else {
                    // loop through every card
                    foreach ($cardRegex as $regex) {
                        // until we find a valid one
                        if (preg_match($regex, $value) === 1) {
                            return true;
                        }
                    }
                }
            }
        }
        // if we've got this far, the card has passed no validation so it's invalid!
        self::setError($field['name'], 'creditCard', 'Wrong card number.');
    }
}
