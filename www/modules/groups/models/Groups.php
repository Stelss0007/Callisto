<?php
namespace app\modules\groups\models;

class Groups extends \app\db\ActiveRecord\Model
  {
  public static $tableName = '`group`';
  
  public static function groupList($full=false)
    {
    $groups = self::findAll();

    if($full)
      return $groups;
    
    $result = array();
    foreach ($groups as $group)
      {
      $result[$group->id] = $group->name;
      }
 
    return $result;
    }
    
  }