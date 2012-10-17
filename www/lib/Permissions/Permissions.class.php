<?php

 function getAccess($obj_name, $level)
   {
   $ses_info=UserSession::getInstance();
   $gid = $ses_info->userGid();
   $perms_list = groupPermsGetList($gid);
  
   if(empty($perms_list))
     return false;
   
   foreach($perms_list as $key=>$permission)
     {
     $pattern = "/$permission[pattern]/Ui";
     if(preg_match($pattern, $obj_name))
       {
       if($level<=$permission['level'])
         {
         //print_r($perms_list[$key]);
         return true;
         }
       return false;
       }
     }
   return false;
   }

/*
   * ���������� � ������ �����
  */
  function groupPermsGetList($gid=null)
    {
    $db=DBConnector::getInstance();
    $db->query("SELECT * FROM sys_user_group_permission WHERE gid='%d' ORDER BY weight", $gid);
    $perms_list = $db->fetch_array();

    return $perms_list;
    }

  /*
   * ���������� � ������ ������
  */
  function groupPermsGetInfo($id)
    {
    $groups_perms_table = sysDBGetTable('groups_perms');
    $groups_perms_column = sysDBGetColumns($groups_perms_table);
    $info = sysDbSelect ($groups_perms_table, $groups_perms_column, "WHERE $groups_perms_column[id]='$id'");
    return ($info);
    }

  /*
   * ���������� ������������� ������ ������� ����->  ������������ ��������
  */
  function permsLevelGetList()
    {
    $levels_list[ACCESS_NONE]='NONE';
    $levels_list[ACCESS_OVERVIEW]='OVERVIEW';
    $levels_list[ACCESS_READ]='READ';
    $levels_list[ACCESS_COMMENT]='COMMENT';
    $levels_list[ACCESS_ADD]='ADD';
    $levels_list[ACCESS_EDIT]='EDIT';
    $levels_list[ACCESS_DELETE]='DELETE';
    $levels_list[ACCESS_ADMIN]='ADMIN';
    return ($levels_list);
    }

  /*
  * ������� ����� ������
  */
  function groupPermsCreate($args)
    {
    //������ ������� ��������� � ����
    $groups_perms_table = sysDBGetTable('groups_perms');
    $groups_perms_column = sysDBGetColumns($groups_perms_table);

    //������� � ������ ����� ������� ���
    $MaxWeight = sysDbMaxWeight ($groups_perms_table);
    $MaxWeight++;
    $args ['weight'] = $MaxWeight;

    sysDbInsert ($groups_perms_table, $args);
    //������� ��� ���� �������
    sysVarDelCached('kernel', 'sec_levels');
    return (mysql_insert_id());
    }

  /*
   * �������� ��������� � ���� ������
  */
  function groupPermsUpdate($args)
    {
    $groups_perms_table = sysDBGetTable('groups_perms');
    $groups_perms_column = sysDBGetColumns($groups_perms_table);
    //��������� ������� � ����.
    unset ($args ['weight']);//������������
    sysDbUpdate ($groups_perms_table, $args, "WHERE $groups_perms_column[id]='$args[id]'");
    //������� ��� ���� ������� ������
    sysVarDelCached('kernel', 'sec_levels');
    return true;
    }

  /*
   * �������� ������ ������
  */
  function groupPermsDelete($id)
    {
    sysExtLibLoad();
    $dbdata = $this->groups_perms_get_info ($id);
    //��������
    $groups_perms_table = sysDBGetTable('groups_perms');
    $groups_perms_column = sysDBGetColumns($groups_perms_table);
    sysDbDelete ($groups_perms_table, "WHERE $groups_perms_column[id]='$id'");
    sysDbWeightDelete ($groups_perms_table, $dbdata['weight'],'');
    //������� ��� ���� ������� ������
    sysVarDelCached('kernel', 'sec_levels');
    return true;
    }

  /*
   * ���������� ��� ������� ������
  */
  function groupPermsMoveUp($id)
    {
    sysExtLibLoad();
    $groups_perms_table = sysDBGetTable('groups_perms');
    $groups_perms_column = sysDBGetColumns($groups_perms_table);
    $dbdata = $this->groups_perms_get_info ($id);

    sysDbWeightMoveUp ($groups_perms_table, $dbdata['weight']);

    sysVarDelCached('kernel', 'sec_levels');
    return true;
    }

  /*
   * ��������� ��� ������� ������
  */
  function groupPermsMoveDown($id)
    {
    sysExtLibLoad();
    $groups_perms_table = sysDBGetTable('groups_perms');
    $groups_perms_column = sysDBGetColumns($groups_perms_table);
    $dbdata = $this->groups_perms_get_info ($id);

    sysDbWeightMoveDown ($groups_perms_table, $dbdata['weight']);

    sysVarDelCached('kernel', 'sec_levels');
    return true;
    }


?>
