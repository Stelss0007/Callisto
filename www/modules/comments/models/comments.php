<?php

class comments extends Model
  {
  var $table = 'comment';
  
  function comment_list($full=false, $filter = array(), $limit = false, $sort = '')
    {
    $where = '';
    if($filter)
      {
      //Уберем с фильтра все ненужное
      foreach($filter as $key=>$value)
        {
        if($value == '0' && $key != 'comment_active')
          {
          unset($filter[$key]);
          }
        elseif($key == 'comment_active' && $value == '-1')
          {
          unset($filter[$key]);
          }
        else
          {
          $filter[$key] = "$key = '$value'";
          }
        }

      $filter_str = implode(' AND ', $filter);
      if($filter_str)
        {
        $where = 'WHERE '.$filter_str;
        }
      }
      
    //Формируем строку лимитов для sql запроса
    $limit['page'] = $this->getInput('page', 1);
    $limit['element_at_page'] = '3';
      
    $sql_limit = '';
    $this->preparePagination($where, $sql_limit);
    
    $result = array();
    $sql = " 
              SELECT a.*, u.login FROM `{$this->table}` a 
              LEFT JOIN {$this->getModelTable('users')} u ON (u.id=a.comment_user_id)
              $where
              ORDER BY comment_add_time
              $sql_limit
            ";
    //appDebug($sql);exit;
    $this->query($sql);
    $comments = $this->fetchArray();
   
    if($full)
      return $comments;
    
    foreach ($comments as $comment)
      {
      $result[$comment['id']] = $comment['comment_title'];
      }

    return $result;
    }
  
  function comment_create($data)
    {
    return $this->insert($this->table, $data);
    }
    
  function comment_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
   
    $this->update($this->table, $data, "id = '$id'");
    }
  }
