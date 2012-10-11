<?php

class work
  {
  /*
   * ����������
  */



  /*
   * �������
  */


  /*
   * ���������� ������ ���� � �������
  */
  function get_list()
    {
    $db=DBConnector::getInstance();
    $db->query("SELECT * FROM work");
    $work_list = $db->fetch_array();
    $result = array();
    foreach($work_list as $item)
      {
      $result[$item['id']] = $item['group_displayname'];
      }
    return $result;
    }

  /*
   * ���������� ���������� � ������
  */
  function get_info($id)
    {
    $work_table = sysDBGetTable ('work');
    $work_column = sysDBGetColumns($work_table);
    $GroupInfo =& sysDbSelect ($work_table, $work_column, "WHERE $work_column[id]='$id'");
    return $GroupInfo;
    }

  /*
   * ������� ������ � �������
  */
  function create($data)
    {
    $work_table = sysDBGetTable ('work');
    $gid = sysDbInsert ($work_table, $data);
    return $gid;
    }

  /*
   * ���������� ���������� � ������ � �������
  */
  function update($data)
    {
    $work_table = sysDBGetTable ('work');
    $work_column = sysDBGetColumns($work_table);
    sysDbUpdate ($work_table, $data, "WHERE $work_column[id] = '$data[id]'");
    return true;
    }

  /*
   * �������� ������ �� �������
  */
  function delete($id)
    {
    $work_table = sysDBGetTable ('work');
    $work_column = sysDBGetColumns($work_table);
    sysDbDelete ($work_table, "WHERE $work_column[id] = '$id'");
    return true;
    }

  }

?>