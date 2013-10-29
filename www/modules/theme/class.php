<?php
class Theme extends Model
  {
  var $table = 'theme';
  public static $relations = array('user'=>array('type'   => RELATION_TYPE_ONE_TO_MANY,
                                                 'action' => RELATION_ACTION_RESTRICT,
                                                 'class'  => 'User',
                                                 'foreign_key'  => 'user_id',
                                                )
                                   );
  }
?>
