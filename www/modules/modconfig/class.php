<?php
class Modconfig extends Model
  {
  var $table = 'mod_config';
  
  public function getVars($modname)
    {
    $result = array();
    $conditions = array(
                       'condition'=>"mod_config_mod_name = ':modname'",
                       'params'=>array(':modname'=>$modname)
                       );
    $vars = $this->getList($conditions);
    foreach($vars as $var)
      {
      $result[$modname]["{$var['mod_config_key']}"] = $var['mod_config_value'];
      }
    return $result;
    }
    
  public function getVar($modname, $modvar)
    {
    return;
    }
    
  public function setVar($mod, $key, $var)
    {
    if(empty($mod) || empty($key) || empty($var))
      return false;
    
    $conditions = array(
                       'condition'=>"mod_config_mod_name = ':modname' AND mod_config_key = ':key'",
                       'params'=>array(':modname'=>$mod, ':key'=>$key)
                       );
    $dbvar = $this->getList($conditions);
    
    if(empty($dbvar))
      {
      $this->mod_config_mod_name = $mod;
      $this->mod_config_key = $key;
      $this->mod_config_value = $var;
      $this->save();
      }
    else
      {
      $this->mod_config_value = $var;
      $this->save($dbvar[0]['id']);
      }
    }
  }
?>
