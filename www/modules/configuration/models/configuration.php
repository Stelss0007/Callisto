<?php
class Configuration extends Model
  {
  var $table = '`configuration`';
  
  public function saveConfiguration($modname, $params)
    {
    $modconfig = $this->getModConfiguration($modname, true);
    
    $this->module = $modname;
    $this->params = serialize($params);
    if($modconfig)
      {
      parent::save($modconfig['id']);
      }
    else
      {
      parent::save();
      }
    }
    
  public function getModConfiguration($modname, $all=false)
    {
    $result = $this->getList(array('condition'=>array('module'=>$modname)));
    if(empty($result))
      {
      return false;
      }
      
    if($all)
      return $result[0];
    
    return unserialize($result[0]['params']);
    }
    
  public function getModConfigurationAll()
    {
    $result = $this->getList();
    if(empty($result))
      {
      return false;
      }
    $config = array();  
    foreach($result as $key => $values)
      {
      $config[$values['module']] = unserialize($values['params']);
      }
    return $config;
    }
  }

