<?php
namespace app\modules\configuration\models;

class Configuration extends \app\db\ActiveRecord\Model
  {
  public static $tableName = '`configuration`';
  
  public static function saveConfiguration($modname, $params)
    {
    $modconfig = self::getModConfiguration($modname, true);

    if(!$modconfig)
      {
      $modconfig = new self;
      }
      
    $modconfig->module = $modname;
    $modconfig->params = serialize($params);
    $modconfig->save();
    }
    
  public static function getModConfiguration($modname, $allInfo=false)
    {
    $result =  self::findOne(['module'=>$modname]);
    if(empty($result))
      {
      return false;
      }
      
    if($allInfo)
        {
        return $result;
        }
    
    return unserialize($result->params);
    }
    
  public static function getModConfigurationAll()
    {
    $results = self::findAll();
    
    if(empty($results))
      {
      return false;
      }
    $config = array();
    foreach($results as $modconfig)
      {
      $config[$modconfig->module] = unserialize($modconfig->params);
      }
    return $config;
    }
  }

