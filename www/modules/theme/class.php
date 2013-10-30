<?php
class Theme extends Model
  {
  var $table = 'theme';
  var $relations = array('user'=>array('type'   => RELATION_TYPE_ONE_TO_ONE,
                                        'action' => RELATION_ACTION_RESTRICT,
                                        'table'  => 'user',
                                        'foreign_key'  => 'user_id',
                                       ),
                         'block'=>array('type'   => RELATION_TYPE_ONE_TO_MANY,
                                        'action' => RELATION_ACTION_RESTRICT,
                                        'table'  => 'block',
                                        'foreign_key'  => 'theme_id',
                                       ),
                        );
  }
?>
