<?php
class Model extends DBConnector
  {
  var $type = '';
  var $vars = array();
  var $table = 'object';
  
  var $session = null;
  
  //////////////////////////////////////////////////////////////////////////////
  function __construct($guid=0)
    {
    global $coreConfig;
    
    //echo "host=".$coreConfig['DB.Host'];
    
    $this->Host = $coreConfig['DB.Host'];
    $this->User = $coreConfig['DB.UserName'];
    $this->Password = $coreConfig['DB.Password'];
    $this->Database = $coreConfig['DB.Name'];
    
    $this->connect();
      
    
//    $this->query('SELECT * FROM test');
//    print_r($this->fetch_array());exit;
    }

  //////////////////////////////////////////////////////////////////////////////
  function __destruct() 
    {
    $this->disconect();
    
    }
  
  //////////////////////////////////////////////////////////////////////////////
  function __set($name, $value)
    {
    if(property_exists($this, $name))
      {
      $this->$name = $value;
      return true;
      }
    $this->vars[$name] = $value;
    
    return true;
    }
    
  //////////////////////////////////////////////////////////////////////////////  
  function getObject($guid=0)
    {
    if(empty($guid))
      return false;
    //������� �������� ���� � ������
    $sql = "SELECT SQL_CACHE  t.type as type,
                              o.guid,
                              o.owner_id,
                              o.time_create,
                              o.time_update,
                              o.active
            FROM `object` o
            LEFT JOIN object_type t ON (t.id = o.type)
            WHERE o.guid = '%d'";
    $this->query($sql, $guid);
    $res_main = $this->fetch_array();
    
    //������� ��� ���� � �������� ������������� ������� 
    $sql = "SELECT SQL_CACHE f.`field`, 
                             v.`value` 
            FROM `object_value` v
            LEFT JOIN `object_field` f ON (f.`id` = v.`field_id`)
            WHERE v.`guid` = '%d'";
    
    $this->query($sql, $guid);
    $res_fields= $this->fetch_array();
    
    $result = array();
    
    //������� �������� ������� ������� � ������� �������(������� ����)
    foreach($res_main[0] as $key=>$val)
      {
      $result[$key][] = $val;
      }
    //������� �������� ������� � ������� �������� �������(�������������� ����)
    foreach($res_fields as $key=>$val)
      {
      $result[$val['field']][] = $val['value'];
      }
    
    foreach($result as $key=>$val)
      {
      if(sizeof($val)==1)
        {
        $result[$key] = $val[0];
        }
      }
    return $result;
    } 
    
  //////////////////////////////////////////////////////////////////////////////  
  function getObjectsList($where_array=array(), $order = array('time_create'=>'asc'), $offset = 0, $limit = 20)
    {
    $left_join ='';
    $right_join ='';
    $order_by ='';
    $where = '';
    
    $left_join_shablon = "LEFT JOIN `object_value` v%d ON (v%d.guid = o.`guid` and v%d.`field_id` = '%d')";
    $right_join_shablon = "RIGHT JOIN `object_value` w%d ON (w%d.guid = o.`guid`)";
    $where_shablon = " and w%d.`field_id` = '%d' and w%d.value IN (%s)";
    ////////////////////////////////////////////////////////////////////////////
    //����������, ������� ���������� ��� ����������
    if(empty($order))
      $order = array('time_create'=>'asc');
    $num = 1;
    foreach($order as $key=>$value)
      {
      if($key == 'time_create')
        {
        $order_by .= "{$key} {$value}, ";
        }
      else
        {
        $fid = $this->getFieldId($key);
        $left_join .= " ".sprintf($left_join_shablon, $num, $num, $num, $fid);
        $order_by .= "v{$num}.value {$value}, ";
        }
      $num++;
      }
      
    if(!empty($order_by))
      {
      $order_by = "ORDER BY ".rtrim($order_by, ', ');
      }
      
      
    ////////////////////////////////////////////////////////////////////////////  
    //��������� WHERE   
    $num_where = 1; 
    if(empty($where_array))
      $where_array=array();
    
    foreach($where_array as $key=>$value)
      {
      if($key == 'time_create')
        {

        }
      else
        {
        $fid_w = $this->getFieldId($key);
        $right_join .= " ".sprintf($right_join_shablon, $num_where, $num_where, $num_where,  $fid_w, $num_where, $value);
        
        $where .= ' '.sprintf($where_shablon, $num_where,  $fid_w, $num_where, $value); 
        }
      $num_where++;
      }
    ////////////////////////////////////////////////////////////////////////////
    
      
    //������� �������
    $type_id = $this->getTypeId($this->type);
    
    $where = ltrim($where, 'and ');
    if(!empty($where_shablon))
      $where = 'WHERE '.$where;

    $sql = "SELECT SQL_NO_CACHE o.guid 
            FROM object o
            $right_join
            $left_join
            $where
            $order_by
            LIMIT %d, %d";
    
    $this->query($sql, $offset, $limit);
    $objects_result = $this->fetch_array();
    
    
    $guids = array();
    foreach ($objects_result as $value)
      {
      $guids[] = $value['guid'];
      }
    
    $guids_str = implode("','", $guids);
    
    //������� ���� � ��������
    $sql = "SELECT SQL_NO_CACHE  v.`guid`, 
                              f.`field`,
                              v.`value`,
                              o.*
            FROM object_value v
            LEFT JOIN `object_field` f ON (f.`id` = v.`field_id`)
            LEFT JOIN `object` o ON (o.`guid` = v.`guid`)
            WHERE v.guid IN ('$guids_str') ORDER BY FIELD(v.`guid`, '$guids_str')";
    
    $this->query($sql);
    $objects_result = $this->fetch_array();

    $object_list =array();
    
    //��� ���� ����� � ������ ���� ����� ��� ��������� ��������, �� ��� ���� ������ ��� ���� ������, 
    //����� ������ ����������� �������
    foreach ($objects_result as $key => $value)
      {
      $object_list["{$value['guid']}"]["{$value['field']}"][] = $value['value'];
      }
    
    //������ ��������, ����� ���� ������, � ����� �� �����  
    foreach($object_list as $key1=>$result)
      foreach($result as $key=>$val)
        {
        if(sizeof($val)==1)
          {
          $object_list["$key1"][$key] = $val[0];
          }
        }
      
    return $object_list;
    }
  
  //////////////////////////////////////////////////////////////////////////////  
  function createObject()
    {
    $fields = array();
    $values = array();
    $guid = 0;
    $curent_time = time();
    
    $type_id = $this->getTypeId($this->type);
    $guid = $this->insert('object', array('type'  =>$type_id,
                                          'time_create'  =>$curent_time,
                                          'time_update'  =>$curent_time,
                                          'active'=>'1',
                                          )
                          );
        
    foreach ($this->vars as $key => $value) 
      {
      $field_id = $this->getFieldId($key);
      
      $this->insert('object_value', array('guid'  =>$guid,
                                          'type_id'  =>$type_id,
                                          'field_id'  =>$field_id,
                                          'value'=> $value
                                          )
                          );

      }
    return $guid;
    }
    
  //////////////////////////////////////////////////////////////////////////////  
  function updateObject($guid=0)
    {
    if(empty($guid))
      {
      return false;
      }
    
    $fields = array();
    $values = array();
    $curent_time = time();
    
    $this->query("START TRANSACTION");
    $this->update('object', array('time_update'  =>$curent_time), "WHERE guid = '$guid'");
        
    foreach ($this->vars as $key => $value) 
      {
      $field_id = $this->getFieldId($key);
      
      $this->query("DELETE FROM object_value WHERE guid='%d' AND field_id = '%d'", $guid, $field_id);
      $this->insert('object_value', array('guid'  =>$guid,
                                          'field_id'  =>$field_id,
                                          'value'=> $value
                                          )
                    );
      
      }
    $this->query("COMMIT");
    
    return $guid;
    }
  //////////////////////////////////////////////////////////////////////////////
  function deleteObject($id)
    {
    if(is_array($id))
      {
      $id = "'".implode("', '", $id)."'";
      }
    else
      {
      $id = "'$id'";
      }
    $sql1 = "DELETE FROM object WHERE guid IN ($id)";
    $sql2 = "DELETE FROM object_value WHERE guid IN ($id)";
    
    $this->query("START TRANSACTION");
    $this->query($sql1);
    $this->query($sql2);
    $this->query("COMMIT");
    
    return true;
    }
  //////////////////////////////////////////////////////////////////////////////  
  function save($guid=0)
    {
    if($this->table == 'object')
      {
      if(empty($guid) && empty($this->vars['guid']))
        {
        return $this->createObject();
        }
      else
        {
        $id = (isset($this->vars['guid'])) ? $this->vars['guid'] : 0;
        if(!empty($guid))
          $id = $guid;

        return $this->updateObject($id);
        }
      }
    else
      {
      if(empty($guid) && empty($this->vars['id']))
        {
        return $this->insert($this->table, $this->vars);
        }
      else
        {
        $id = (isset($this->vars['id'])) ? $this->vars['id'] : 0;
        if(!empty($guid))
          $id = $guid;
        
        $this->update($this->table, $this->vars, "id = '{$id}'");
        return $id;
        }
     
      }
    }
    
  function delete($id)
    {
    if($this->table == 'object')
      {
      $this->deleteObject($id);
      }
    else
      {
      $this->query("DELETE FROM {$this->table} WHERE id = '%d'", $id);
      }
    }
  
  //////////////////////////////////////////////////////////////////////////////
  function getTypeId($type='')
    {
    if(empty($type))
      return false;
    $type_id = 0;
    
    $this->query("SELECT SQL_CACHE id FROM object_type WHERE type='%s'", $type);
    $result = $this->fetch_array();    
    
    if(!empty($result[0]))
      return $result[0]['id'];
    
    return $this->insert('object_type', array('type'=>$type));
    }
  
  //////////////////////////////////////////////////////////////////////////////
  function getFieldId($field='')
    {
    if(empty($field))
      return false;
    $field_id = 0;
    
    $this->query("SELECT SQL_CACHE id FROM object_field WHERE field = '%s'", $field);
    $result = $this->fetch_array();    
    
    if(!empty($result[0]))
      return $result[0]['id'];
    
    return $this->insert('object_field', array('field'=>$field));
    }
    
  //////////////////////////////////////////////////////////////////////////////
  function __call($name, $arguments) 
    {
    if(preg_match('/^get(.*)/simu', $name, $matches))
      {
      if($this->table == 'object')
        {
        return $this->objectTypeORM($name, $arguments);
        }
      else
        {
        return $this->modelTypeORM($name, $arguments);
        }
      }
    
    }
  
  function objectTypeORM($name, $arguments)
    {
    $limit = 1000;
    $offset = 0;

    if(preg_match('/^get_(\d+)_(\d+)_(.*)/simu', $name, $matches))
      {
      $offset = $matches[1];
      $limit = $matches[2];
      $name = 'get'.$matches[3];
      }
    elseif(preg_match('/^get_(\d+)_(.*)/simu', $name, $matches))
      {
      $limit = $matches[1];
      $name = 'get'.$matches[2];
      }
    preg_match('/^getBy(.*)OrderBy(.*)/simu', $name, $matches);
    if($matches)
      {
      $field = strtolower($matches[1]);
      $value = $arguments[0];
      $order = $matches[2];
      return $this->getObjectsList(array($field => $value), array($order => 'asc'), $offset, $limit);
      }
    preg_match('/^getBy(.*)/simu', $name, $matches);
    if($matches)
      {
      $field = strtolower($matches[1]);
      $value = $arguments[0];
      return $this->getObjectsList(array($field => $value), '', $offset, $limit);
      }
    }
    
  function modelTypeORM($name, $arguments)
    {
    
    $columns = $this->tableFieldList();
   
    $limit = 1000;
    $offset = 0;

    if(preg_match('/^get_(\d+)_(\d+)_(.*)/simu', $name, $matches))
      {
      $offset = $matches[1];
      $limit = $matches[2];
      $name = 'get'.$matches[3];
      }
    elseif(preg_match('/^get_(\d+)_(.*)/simu', $name, $matches))
      {
      $limit = $matches[1];
      $name = 'get'.$matches[2];
      }
      
    preg_match('/^getBy(.*)OrderBy(.*)/simu', $name, $matches);
    if($matches)
      {
      $field = strtolower($matches[1]);
      $value = $arguments[0];
      $order = $matches[2];
      return $this->select($this->table, '*', "WHERE $field IN($value) ORDER BY $order ASC LIMIT $offset, $limit", true);
      //return $this->getObjectsList(array($field => $value), array($order => 'asc'), $offset, $limit);
      }
      
    preg_match('/^getBy(.*)/simu', $name, $matches);
    if($matches)
      {
      $field = strtolower($matches[1]);
      $value = $arguments[0];
      return $this->select($this->table, '*', "WHERE $field IN($value) LIMIT $offset, $limit", true);
      //return $this->getObjectsList(array($field => $value), '', $offset, $limit);
      }
    }
    
  function tableFieldList($table = null)
    {
    if(empty($table))
      $table = $this->table;
    //��������� ���� ���� � ���� ���������� �� ����
    $cached_columns = appVarGetCached('core', 'columns');
    if ($cached_columns[$table]) 
      return $cached_columns[$table];
    
    $this->query('SHOW COLUMNS FROM '.$table);
    $columns = $this->fetch_array();
    
    $result = array();
    foreach($columns as $value)
      $result[$table][] = $value['Field'];
    
    //������ � ���
    appVarSetCached('core', 'columns', $result);
    
    return $result[$table];
    }
    
  function weightMax($where='')
    {
    if($this->table != 'object')
      {
      $where = str_replace('WHERE', '', $where);
      if(!empty($where))
        $where = ' WHERE '.$where;
      $this->query("SELECT MAX(weight) as max FROM {$this->table}".$where);
      $result = $this->fetch_array();
      $maxweight = $result[0]['max'];
      return $maxweight;
      }
    }
  function weightDelete($weight, $where='')
    {
    if($this->table != 'object')
      {
      $where = str_replace('WHERE', '', $where);
  
      if ($where!='')
        {
        $where=" AND $where";
        };

      $this->query("UPDATE {$this->table} SET weight = weight-1 WHERE weight >'$weight' $where");

      return true;
      }
    }
    
  function weightUp($weight=0, $where='')
    {
    if($weight<2)
      return true;
    
    if($this->table != 'object')
      {
      $where = str_replace('WHERE', '', $where);
      if ($where!='')
        {
        $where=" AND $where";
        }
      
      $next_weight = $weight--;
      $this->query("SELECT * FROM {$this->table} WHERE weight IN ('$weight', '$next_weight') $where ORDER BY weight LIMIT 2");
      $dbresult = $this->fetch_array();

      //????????????
      $dbresult[0][weight]++;
      $dbresult[1][weight]--;

      foreach ($dbresult as $newresult)
        $this->query("UPDATE {$this->table} SET weight = '$newresult[weight]' WHERE id = '$newresult[id]'");

      return true;
      }
    }
    
  function weightDown($weight=0, $where='')
    {
    $MaxWeight = $this->weightMax();
    if ($weight == $MaxWeight || $weight == 0)
      return true;
    
    if($this->table != 'object')
      {
      $where = str_replace('WHERE', '', $where);
      if ($where!='')
        {
        $where=" AND $where";
        }
      
      $next_weight = $weight++;
      $this->query("SELECT * FROM {$this->table} WHERE weight IN ('$weight', '$next_weight') $where ORDER BY weight LIMIT 2");
      $dbresult = $this->fetch_array();

      //????????????
      $dbresult[0][weight]++;
      $dbresult[1][weight]--;

      foreach ($dbresult as $newresult)
        $this->query("UPDATE {$this->table} SET weight = '$newresult[weight]' WHERE id = '$newresult[id]'");

      return true;
      }
    }
  
  ///////////////////////////// FINDING ///////////////////////////////////////
   
  final private function prepareCondition($conditions = array(), $params = array())
    {
    $offset = 0;
    $limit = 1000;
    $where = '';
    
    $result = array();
    $result['where'] = '';
    $result['group'] = '';
    $result['order'] = '';
    $result['fields'] = '';
    $result['limit'] = '';
    $result['join'] = '';
    
    
    if(isset($conditions['fields']) && !empty($conditions['fields']))
      {
      $result['fields'] = $conditions['fields'];
      }
    else
      {
      $result['fields'] =array();
      }
      
    if($conditions['condition']&& !empty($conditions['condition']))
      {
      //If array of condition
      if(is_array($conditions['condition']))
        {
        $where_ = '';
        foreach($conditions['condition'] as $key=>$value)
          {
          if(is_array($value))
            {
            $value = implode("' , '", $value);
            if($value)
              {
              $value = "('$value')";
              $where_ .= " AND $key IN $value ";
              }
            }
          else
            {
            preg_match_all("/^([<>=!]+|like).*$/is", $value, $operator);
              if($operator)
                {
                $value = trim(preg_replace("/^(<>|<|>|!=|like)(.*)$/is", "$2", $value));
                //print_r($operator);exit;
                $curret_operator = $operator[1][0];

                if(strtoupper($curret_operator) != 'LIKE')
                  {
                  $value = $this->prepareValue($value);
                  }

                $where_ .= " AND $key $curret_operator $value ";
                }
              else
                {
                $value = $this->prepareValue($value);
                $where_ .= " AND $key = '$value' ";
                }              
              }
          }

        if(!empty($where_))
          {
          $where = " WHERE ". ltrim($where_, ' AND ');
          }
        }
      elseif(is_string($conditions['condition'])) 
        {
        $where = str_ireplace('WHERE', '', trim($conditions['condition']));
        $where = " WHERE ".$where;
        }
        
      if($conditions['params'] && !empty($conditions['params']))
        {
        $search = array_keys($conditions['params']);
        $replace = $this->prepareValue(array_values($conditions['params']));
        
        $where = str_replace($search, $replace, $where);
        }
      }
    
    //Set join tables
    if($conditions['join'])
      {
      $join = $conditions['join'];
      }
    else
      {
      $join = '';
      }
      
    //Set where hight priority  
    if(isset($conditions['where']) && !empty($conditions['where']))
      {
      $where = str_ireplace('WHERE', '', trim($conditions['where']));
      $where = " WHERE ".$where;
      }
    
    //Set offset
    if(isset($conditions['offset']) && !empty($conditions['offset']))
      {
      $offset = $conditions['offset'];
      }
      
    //Set limit  
    if(isset($conditions['limit']) && !empty($conditions['limit']))
      {
      $limit = $conditions['limit'];
      }
      
    //Set order by  
    if(isset($conditions['order']) && !empty($conditions['order']))
      {
      $result['order'] = " ORDER BY {$conditions['order']}";
      }
      
    //Set group by  
    if(isset($conditions['group']) && !empty($conditions['group']))
      {
      $result['group'] = " GROUP BY {$conditions['group']}";
      }

      
    $result['join'] = $join; 
    $result['where'] = $where; 
    $result['limit'] = " LIMIT $offset, $limit"; 
   
    return $result;
    }


  /**
   * 
   * @param array $conditions
   * @param array $params
   * @return array
   * 
   *     $params = array(
   *                 'fields' => array('id', 'login'),
   *                 'limit' => 4,
   *                 'offset' => 0,
   *                 'order' => 'id',
   *                 'condition' => "id > :id1 and id < :id2", 
   *                 'condition' => array('id'=>array('4', '8')), 
   *                 'params' => array(':id1'=>5, ':id2'=>10)
   *                 );
   */  
  final function getList($conditions = array(), $params = array())
    {
    $condition = $this->prepareCondition($conditions, $params);
    $where = "{$condition['join']} {$condition['where']} {$condition['group']} {$condition['order']} {$condition['limit']}";
    return $this->select($this->table, $condition['fields'], $where, true);   
    }
   
  final function getCount($params)
    {
    $params['fields'] = 'COUNT(*) as count';
    $result = $this->getList($params);
    return $result[0]['count']; 
    }
    
  final function getFirst($params)
    {
    $params['limit'] = 1;
    $params['order'] = 'id';
 
    $result = $this->getList($params);
    
    return $result[0];
    }
    
  final function getLast($params)
    {
    $params['limit'] = 1;
    $params['order'] = 'id DESC';
 
    $result = $this->getList($params);
    
    return $result[0];
    }
    
  final function deleteAll($conditions = array(), $params = array())
    {
    $condition = $this->prepareCondition($conditions, $params);
    $where = "{$condition['join']} {$condition['where']} {$condition['limit']}";
    $this->query("DELETE FROM {$this->table} $where)");
    }
  }
?>
