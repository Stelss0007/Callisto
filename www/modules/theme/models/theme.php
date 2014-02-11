<?php
class Theme extends Model
  {
  var $table = 'theme';
  var $relations = array('user'=> array('type'   => RELATION_TYPE_ONE_TO_ONE,
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
  
  function getActiveName()
    {
    $theme = $this->getList(array('condition'=>"active = '1'"));
  
    return $theme[0]['theme_name'];
    }
    
  /**
   * ��������� ����, ��� ��������� ��������������.
   * @param int $id �� �������������� ����
   */
  function activate($id)
    {
    $this->update($this->table, array('active'=>'0'), '');
    $this->active = 1;
    $this->save($id);
    }
    
   /**
    * �������� ��������� � �������� ������� ���. ����� ������� �����  info.php
    * @return array ������ ��� � ��
    */ 
  function fileSystemList()
    {
    $theme_list_all = array();
    $dir_handler = opendir('themes');
    while ($dir = readdir($dir_handler))
      {
      if ((is_dir("themes/$dir")) &&
                    ($dir != '.') &&
                    ($dir != '..') &&
                    ($dir != 'CVS') &&
                    (file_exists ("themes/$dir/info.php")))
        {
        // Found
        $info = array();
        $info['version'] = '0';
        $info['description'] = '';
        include("themes/$dir/info.php");
        $info['name'] = $dir;
        array_push ($theme_list_all, $info);
        }
      }
    closedir($dir_handler);
    
    return $theme_list_all;
    }
    
  /**
    * �������� ���������� � �������� ������� ���.
    * @return array ������ ��� � ��
    */ 
  function fileSystemListActual()
    {
    $theme_list_fs = &$this->fileSystemList();
    $theme_list_db = $this->getList();
    
    foreach($theme_list_db as $theme_db)
      {
      foreach($theme_list_fs as $key => $theme_fs)
        {
        if($theme_db['theme_name'] == $theme_fs['name'])
          unset($theme_list_fs[$key]);
        }
      }
    return $theme_list_fs;
    }
  }
?>
