<?php
class Model extends DBConnector
  {
  var $type = '';
  var $vars = array();
  
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
    //Получим основную инфу о бъекте
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
    
    //Выведим все поля и значения принадлежащие объекту 
    $sql = "SELECT SQL_CACHE f.`field`, 
                             v.`value` 
            FROM `object_value` v
            LEFT JOIN `object_field` f ON (f.`id` = v.`field_id`)
            WHERE v.`guid` = '%d'";
    
    $this->query($sql, $guid);
    $res_fields= $this->fetch_array();
    
    $result = array();
    
    //Соберем свойства объекта сначала с главной таблицы(главная инфа)
    foreach($res_main[0] as $key=>$val)
      {
      $result[$key][] = $val;
      }
    //Соберем свойства объекта с таблицы значений объекта(второстепенная инфа)
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
    
    $left_join_shablon = "LEFT JOIN `object_value` v%d ON (v%d.guid = o.`guid` and v%d.`field_id` = '%d')";
    $right_join_shablon = "RIGHT JOIN `object_value` w%d ON (w%d.guid = o.`guid` and w%d.`field_id` = '%d' and w%d.value = '%d')";
    
    ////////////////////////////////////////////////////////////////////////////
    //Сортировка, соберем переменные для сортировки
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
    //Обработка WHERE   
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
        }
      $num_where++;
      }
    ////////////////////////////////////////////////////////////////////////////
    
      
    //Получим объекты
    $type_id = $this->getTypeId($this->type);
    $sql = "SELECT SQL_NO_CACHE o.guid 
            FROM object o
            $right_join
            $left_join
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
    
    //Получим поля к объектам
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
    
    //Это типа когда у одного поля может біть несколько значений, мы для всех задаем что поле массив, 
    //Потом лишнее преобразуем обратно
    foreach ($objects_result as $key => $value)
      {
      $object_list["{$value['guid']}"]["{$value['field']}"][] = $value['value'];
      }
    
    //Теперь разберем, какое поле массив, а какое не масив  
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
  }
?>
