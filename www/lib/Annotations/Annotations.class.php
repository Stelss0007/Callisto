<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Annotations
 *
 * @author Your Name <your.name at your.org>
 */
class Annotations
  {
  var $classCurrent = null;
  var $reflectionClass = null;
  var $classAnnotations = array();
  var $fieldsAnnotations = array();
  var $methodsAnnotations = array();
  
  private static $ignoredList = array(
                                      'access'=> true, 'author'=> true, 'copyright'=> true, 'deprecated'=> true,
                                      'example'=> true, 'ignore'=> true, 'internal'=> true, 'link'=> true, 'see'=> true,
                                      'since'=> true, 'tutorial'=> true, 'version'=> true, 'package'=> true,
                                      'subpackage'=> true, 'name'=> true, 'global'=> true, 'param'=> true,
                                      'return'=> true, 'staticvar'=> true, 'category'=> true, 'staticVar'=> true,
                                      'static'=> true, 'var'=> true, 'throws'=> true, 'inheritdoc'=> true,
                                      'inheritDoc'=> true, 'license'=> true, 'todo'=> true,
                                      'deprec'=> true, 'property' => true, 'method' => true,
                                      'abstract'=> true, 'exception'=> true, 'magic' => true, 'api' => true,
                                      'final'=> true, 'filesource'=> true, 'throw' => true, 'uses' => true,
                                      'usedby'=> true, 'private' => true, 'Annotation' => true, 'override' => true,
                                      'codeCoverageIgnore' => true, 'codeCoverageIgnoreStart' => true, 'codeCoverageIgnoreEnd' => true,
                                      'Required' => true, 'Attribute' => true, 'Attributes' => true,
                                      'Target' => true, 'SuppressWarnings' => true,
                                      'ingroup' => true, 'code' => true, 'endcode' => true
                                    );
  
  
  function __construct($class=null) 
    {
    if(!empty($class))
      $this->setClass($class);
    }
    
  function setClass($class)
    {
    $this->classCurrent = $class;
    $this->reflectionClass = new ReflectionClass($class);
    
    $this->setClassAnnotations();
    $this->setFieldsAnnotations();
    $this->setMethodsAnnotations();
    }
  function setClassAnnotations()
    {
    $comment = $this->reflectionClass->getDocComment();
    if (preg_match_all('/@(\w+)(.*)\r?\n/m', $comment, $matches))
      {
      $var_count = count($matches[0]);
      for($i = 0; $i<$var_count; $i++)
        {
        if(array_key_exists($matches[1][$i], self::$ignoredList))
          continue;
        
        $params = array();
        if(preg_match_all("/(.*?)=(.*?)(,|$)/", str_replace(array('(',')'), '', $matches[2][$i]), $matches2))
            {
            $params_count = count($matches2[0]);
            for($p = 0; $p<$params_count; $p++)
              {
              $params[trim($matches2[1][$p])] = trim($matches2[2][$p]);
              }
            }
          
        $this->classAnnotations[] = array('function'=>$matches[1][$i], 'params'=>$params);
        }
      }
    }
  function setFieldsAnnotations()
    {
    $properties = $this->reflectionClass->getProperties();

    foreach($properties as $property)
      {
      $comment = $property->getDocComment();
      if (preg_match_all('/@(\w+)(.*)\r?\n/m', $comment, $matches))
        {
        $var_count = count($matches[0]);
        for($i = 0; $i<$var_count; $i++)
          {
          if(array_key_exists($matches[1][$i], self::$ignoredList))
            continue;
          
          $params = array();
          if(preg_match_all("/(.*?)=(.*?)(,|$)/", str_replace(array('(',')'), '', $matches[2][$i]), $matches2))
            {
            $params_count = count($matches2[0]);
            for($p = 0; $p<$params_count; $p++)
              {
              $params[trim($matches2[1][$p])] = trim($matches2[2][$p]);
              }
            }
          
          $this->fieldsAnnotations["{$property->name}"][] = array('function'=>$matches[1][$i], 'params'=>$params);
          }
        }
      }
    }
  function setMethodsAnnotations()
    {
    $methods = $this->reflectionClass->getMethods();

    foreach($methods as $method)
      {
      $comment = $method->getDocComment();
      if (preg_match_all('/@(\w+)(.*)\r?\n/m', $comment, $matches))
        {
        $var_count = count($matches[0]);
        for($i = 0; $i<$var_count; $i++)
          {
          if(array_key_exists($matches[1][$i], self::$ignoredList))
            continue;

          $params = array();
          if(preg_match_all("/(.*?)=(.*?)(,|$)/", str_replace(array('(',')'), '', $matches[2][$i]), $matches2))
            {
            $params_count = count($matches2[0]);
            for($p = 0; $p<$params_count; $p++)
              {
              $params[trim($matches2[1][$p])] = trim($matches2[2][$p]);
              }
            }
                               
          $this->methodsAnnotations["{$method->name}"][] = array('function'=>$matches[1][$i], 'params'=>$params);
          }
        }
      }
    }
    
    //TODO
    //Доделать  кеширование
  }


