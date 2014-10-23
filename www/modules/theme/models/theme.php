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
    
  function getActive()
    {
    $result = $this->getList(array('condition'=>"active = '1'"));
    
    if($result)
      return $result[0];
    return false;
    }
  /**
   * Активация темы, все остальные деактивируются.
   * @param int $id ИД активируваемой темы
   */
  function activate($id)
    {
    $this->update($this->table, array('active'=>'0'), '');
    $this->active = 1;
    $this->save($id);
    }
    
   /**
    * Перечень доступных в файловой системе тем. Нужно наличие файла  info.php
    * @return array Список тем в ФС
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
    * Перечень актуальных в файловой системе тем.
    * @return array Список тем в ФС
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
    
  function groupActionDelete($ids)
    {
    $active_theme = $this->getActive();
    $ids = array_diff($ids, array($active_theme['id']));
    if(empty($ids))
      return false;
    
    $ids = implode("','", $ids);
    $this->query("DELETE FROM {$this->table} WHERE id in ('$ids')");
    }
    
  function install($theme_name)
    {
    //Взяли список с диска
    if(!file_exists ("themes/$theme_name/info.php")) 
      die ('Тема отсутствует!');

    // Found
    $info = array();
    $info['version']      = '0';
    $info['description']  = '';
    
    include("themes/$theme_name/info.php");
    
    $info['theme_name']         = $theme_name;
    $info['theme_title']        = $info['title'];
    $info['theme_author']       = $info['author'];
    $info['theme_description']  = $info['description'];
    $info['theme_version']      = $info['version'];
    $info['theme_last_update']  = time();

   
    $this->arrayToModel($this, $info);
     
    $id = $this->save();
    }
  function groupActionInstall($themes)
    {
    if(empty($themes))
      return false;
    
    foreach($themes as $theme)
      {
      $this->install($theme);
      }
    }
  }
?>
