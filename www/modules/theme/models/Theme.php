<?php
namespace app\modules\theme\models;

class Theme extends \app\db\ActiveRecord\Model
  {
  public static $tableName = 'theme';
  
  public static function getActiveName()
    {
    $theme = self::findOne(['active' => '1']);
  
    return $theme->theme_name;
    }
    
  public static function getActive()
    {
    $theme = self::findOne(['active' => '1']);
    
    if($theme)
        {
        return $theme;
        }
    return false;
    }
  /**
   * Активация темы, все остальные деактивируются.
   * @param int $id ИД активируваемой темы
   */
  public static function activate($id)
    {
    self::updateAll(['active'=>'0'], ['active'=>'1']);
    
    $theme = self::find($id);
    if(!$theme){return false;}
    
    $theme->active = '1';
    $theme->save();
    }
    
   /**
    * Перечень доступных в файловой системе тем. Нужно наличие файла  info.php
    * @return array Список тем в ФС
    */ 
  public static function fileSystemList()
    {
    $themeListAll = [];
    $dirHandler = opendir('themes');
    while ($dir = readdir($dirHandler))
      {
      if ((is_dir("themes/$dir")) &&
                    ($dir != '.') &&
                    ($dir != '..') &&
                    ($dir != 'CVS') &&
                    (file_exists ("themes/$dir/info.php")))
        {
        // Found
        $info = [];
        $info['version'] = '0';
        $info['description'] = '';
        include("themes/$dir/info.php");
        $info['name'] = $dir;
        array_push ($themeListAll, $info);
        }
      }
    closedir($dirHandler);
    
    return $themeListAll;
    }
    
  /**
    * Перечень актуальных в файловой системе тем.
    * @return array Список тем в ФС
    */ 
  public static function fileSystemListActual()
    {
    $themeListFs = self::fileSystemList();
    $themeListDB = self::findAll();
    
    foreach($themeListDB as $themeDB)
      {
      foreach($themeListFs as $key => $themeFs)
        {
        if($themeDB->theme_name == $themeFs['name'])
          unset($themeListFs[$key]);
        }
      }
    return $themeListFs;
    }
    
  public static function groupActionDelete($ids)
    {
    $activeTheme = self::getActive();
    $ids = array_diff($ids, array($activeTheme->id));
    if(empty($ids))
      return false;

    self::deleteAll(['id'=>$ids]);
    }
    
  public static function install($themeName)
    {
    //Взяли список с диска
    if(!file_exists ("themes/$themeName/info.php")) 
      die ('Тема отсутствует!');

    // Found
    $info = array();
    $info['version']      = '0';
    $info['description']  = '';
    
    include("themes/$themeName/info.php");
    
    $info['theme_name']         = $themeName;
    $info['theme_title']        = $info['title'];
    $info['theme_author']       = $info['author'];
    $info['theme_description']  = $info['description'];
    $info['theme_version']      = $info['version'];
    $info['theme_last_update']  = time();
    
    $theme = new self();
    $theme->setAttributesByArray($info);
    $theme->save();
    }
    
  public static function groupActionInstall($themes)
    {
    if(empty($themes))
      return false;
    
    foreach($themes as $theme)
      {
      self::install($theme);
      }
    }
  }

