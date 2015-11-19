<?php
namespace app\modules\groups\models;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
      $result[$group->id] = $group->group_displayname;
      }
 
    return $result;
    }
    
  }