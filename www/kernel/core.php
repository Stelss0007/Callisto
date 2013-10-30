<?php
include_once 'kernel/constants.php';

appLibLoad('Smarty');
appLibLoad('DBConnector');
appLibLoad('UserSession');


$db = new DBConnector();

function appDebug($value)
  {
  echo "<pre>";
  print_r($value);
  echo "</pre>";
  }

$ses_info = new UserSession();
/**
 * @desc ?????????????? ???????
 * @return bool
 */
function appInit()
  {
  //?????? ???????? ????????? ????
  //include_once 'lang/rus/kernel.php';

  //????????? ????????? ?? ????????????????? ?????
  global $coreConfig;
  $coreConfig = array();
  include_once 'kernel/config.php';

  // ????????? ???????? PHP
  if ($coreConfig['locale.lc_all']) setlocale(LC_ALL, $coreConfig['locale.lc_all']);
	  else setlocale(LC_ALL, 'ru_RU.CP1251');
  ignore_user_abort(true);

  // ???? ????? ?????????? ?????? ? ????? ?? ???????
  if ($coreConfig['DB.Encoded'])
    {
    $coreConfig['DB.UserName'] = base64_decode($coreConfig['DB.UserName']);
    $coreConfig['DB.Password'] = base64_decode($coreConfig['DB.Password']);
    $coreConfig['DB.Encoded'] = 0;
    }

  header("Content-Type: text/html; charset=windows-1251");

  //????????? ??? ???????
  if ($coreConfig['debug.enabled'])
    error_reporting (E_ALL ^ E_NOTICE);
    else
      error_reporting (E_ERROR);

  return true;
  }
  

/**
 * @desc ??????? ?????????? ?? ???????? ?????
 * @return misc
 */
function appCleanFromInput()
  {
  $search = array('|</?\s*SCRIPT.*?>|si',
                  '|</?\s*FRAME.*?>|si',
                  '|</?\s*OBJECT.*?>|si',
                  '|</?\s*META.*?>|si',
                  '|</?\s*APPLET.*?>|si',
                  '|</?\s*LINK.*?>|si',
                  '|</?\s*IFRAME.*?>|si',
                  '|STYLE\s*=\s*"[^"]*"|si');

  $replace = array('');

  $resarray = array();
  foreach (func_get_args() as $var)
    {
    // ???????? ??????????
    global $$var;
    if (empty($var)) return;
    $vars = $$var;
    if (!isset($vars))
      {
      array_push($resarray, NULL);
      continue;
      }
    if (empty($vars))
      {
      array_push($resarray, $vars);
      continue;
      }

		// ??????? ??????????
		if (get_magic_quotes_gpc()) appStripslashes($vars);
		$vars = preg_replace($search, $replace, $vars);

		array_push($resarray, $vars);
		}

	// ?????????? ?????????
	if (func_num_args() == 1)
		return $resarray[0];
		else
			return $resarray;
  }

/**
 * @desc ??????? ?????????? ?? ???????? ?????
 * @return misc
 */
function appCleanInputArray()
  {
  $search = array('|</?\s*SCRIPT.*?>|si',
                  '|</?\s*FRAME.*?>|si',
                  '|</?\s*OBJECT.*?>|si',
                  '|</?\s*META.*?>|si',
                  '|</?\s*APPLET.*?>|si',
                  '|</?\s*LINK.*?>|si',
                  '|</?\s*IFRAME.*?>|si',
                  '|STYLE\s*=\s*"[^"]*"|si');

  $replace = array('');

  $input_array = array();
  foreach (func_get_args() as $var)
    {
    $input_array = array_merge($input_array, $var);
    }

  foreach ($input_array as $key=>$value)
    {
		// ??????? ??????????
		if (get_magic_quotes_gpc()) appStripslashes($value);
		$value = preg_replace($search, $replace, $value);
		$input_array[$key] = $value;
		}
  return $input_array;
  }

/**
 * @desc Strip slashes ????????????? ? coreVarCleanFromInput
 * @return misc
 */
function appStripslashes (&$value)
  {
  if(!is_array($value))
    $value = stripslashes($value);
    else
      array_walk($value,'coreStripslashes');
  }
  
function app_cp1251_utf8 (&$value)
  {
  if(!is_array($value))
    $value = iconv('cp1251', 'utf-8', $value);
    else
      array_walk($value,'core_cp1251_utf8');
  }



/********************?????????, ?????????, ?????? *******************/
function appShowMessage($url, $message='', $time=1)
  {
  global $ses_info;
  $ses_info->setVar('appMsgUrl', $url);
  $ses_info->setVar('appMsgMessage', $message);
  $ses_info->setVar('appMsgTime', $time);
  appRedirect ($url);

  exit;
  };


function appRedirect($redirecturl)
  {
  $redirecturl = str_replace('&amp;', '&', $redirecturl);
  if (preg_match('!^http!', $redirecturl))
    {
    Header("Location: $redirecturl");
    //return true;
    }
    else
      {
      $redirecturl = preg_replace('!^/*!', '', $redirecturl);
      $baseurl = "http://".appGetBaseURI();
      Header("Location: $baseurl$redirecturl");
      }
  exit;
  }


function appGetBaseURI()
  {
  global $_SERVER;

  // Start of with REQUEST_URI
  if (isset($_SERVER['REQUEST_URI']))
    {
    $path = $_SERVER['REQUEST_URI'];
    }
    else
      {
      $path = getenv('REQUEST_URI');
      }
  if ((empty($path)) || (substr($path, -1, 1) == '/'))
    {
    // REQUEST_URI was empty or pointed to a path
    // Try looking at PATH_INFO
    $path = getenv('PATH_INFO');
    if (empty($path))
      {
      // No luck there either
      // Try SCRIPT_NAME
      if (isset($_SERVER['SCRIPT_NAME']))
        {
        $path = $_SERVER['SCRIPT_NAME'];
        }
        else
          {
          $path = getenv('SCRIPT_NAME');
          }
      }
    }

    $path = preg_replace('/[#\?].*/', '', $path);
    $path = dirname($path);

    if (preg_match('!^[/\\\]*$!', $path))
      {
      $path = '';
      }
  $path = $_SERVER['HTTP_HOST'].'/'.$path;
  return $path;
  }



function appCaptureMessage()
  {
  global $ses_info;

  $url = $ses_info->getVar('appMsgUrl');
  if (!isset ($url))
    {
    return false;//??????? ???? ??? ???????
    };
  //?????? &amp; -> & HTML 4.01 :))
  $url = str_replace('&amp;', '&', $url);

  global $module;
  if(!empty($module) && strstr($url, 'index.php?') && !strstr($url, $module) && !strstr($url, str_replace ('app_', '', $module))) //?????
    {
    return false;//??????? ???? ??????? ?? ??? ?????? ??????
    };

  //???? ????? ?? ???? ?????????? ???????
  $message = $ses_info->getVar('appMsgMessage');
  $time = $ses_info->getVar('appMsgTime');
  //??????? ?? ?????? ??????????
  $ses_info->delVar('appMsgUrl');
  $ses_info->delVar('appMsgMessage');
  $ses_info->delVar('appMsgTime');
  //??????????? ????????
  header("Refresh: $time;url=$url");
  //????????
  $appTpl = new coreTpl();
  $appTpl->caching = false;
  $appTpl->assign('url', $url);
  $appTpl->assign('message', $message);
  $appTpl->assign('time', $time);
  //??????? ?? ? ??? ? ????? (????? ????)
  //$themename = appUserTheme ();
  //$appTpl->display("themes/test/messages/normal.tpl");
  $appTpl->display("themes/green_test/messages/normal.tpl");
//  $msgcontent = $appTpl->fetch("themes/test/messages/normal.tpl");
//  echo ($msgcontent);
  //????????????? ???????
  exit;
  }
/******************** ?????????????? ???? **************************\

/**
 * ???????? ?????????? ??????
 */
function appLibLoad($lib_name = 'extlib')
  {
  //???????? ????? ??? ????????? ?
  static $loaded = array();
  
  if (!empty($loaded["$lib_name"])) return true;

  //????????? ????
  require_once('./lib/'.$lib_name.'/'.$lib_name.'.class.php');

  $loaded["$lib_name"] = true;
  return true;
  }
  
  
function appJsLoad($modname='kernel', $scriptname='main')
  {
  global $jsLoaded;
  
  if (!empty($jsLoaded["$modname.$scriptname"])) 
    return true;
  
  if($modname == 'kernel')
    {
    if($scriptname == 'main')
      {
      $jsLoaded["$modname.$scriptname"] = "/scripts/js/$scriptname.js";
      }
    else
      {
      $jsLoaded["$modname.$scriptname"] = "/scripts/js/$scriptname/$scriptname.js";
      }
    }
  else
    {
    if($scriptname == 'main')
      {
      $jsLoaded["$modname.$scriptname"] = "/scripts/js/$scriptname.js";
      }
    else
      {
      $jsLoaded["$modname.$scriptname"] = "/modules/$modname/js/$scriptname.js";
      }
    }

  return true;
  }





/*************************  ????????? ****************************\
/**
 * @desc ?????????? ??? ????????????? ??????????? ??????
 * @return null
 * @param sender string
 * @param excType integer
 * @param message string
 * @param vars array
 */
function appException ($sender, $excType=BAD_PARAM, $message='', $vars = null)
  {
  global $module;
  global $type;
  global $func;
  global $HTTP_SERVER_VARS;
  $uri = $HTTP_SERVER_VARS['REQUEST_URI'];
  $referer = $HTTP_SERVER_VARS['HTTP_REFERER'];

  echo "Caught exception : $message <br>";
  echo "Exception type : $excType<br>";
  echo "Sender : $sender<br><br>";
  echo "Module : $module<br>";
  echo "Module type: $type<br>";
  echo "Funk : $func<br>";

  echo "URI : $uri<br>";
  echo "REFERER : $referer<br>";

  //????? ? ??????
  $vars['module'] = $module;
  $vars['type'] = $type;
  $vars['func'] = $func;
  
  exit;
  };



/************************** ?????  *******************************/
//??????? ??? ????? ? ?????????? ? ??????????? ?? ????? ??????

function appBlockShowAll(&$myTpl, &$object)
  {
  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();
  $db->query("SELECT * FROM blocks WHERE block_active = '1' ORDER BY block_position, block_weight");
  $db_block_list = $db->fetch_array();
//  echo '????????? ????????:<br><pre>';
//  print_r($object);
//  echo '</pre>';
//  exit;

  $result_blocks = array ();
  $result_blocks['left']=array ();
  $result_blocks['right']=array ();
  $result_blocks['top']=array ();
  $result_blocks['bottom']=array ();
  $result_blocks['center']=array ();

  foreach($db_block_list as $item)
    {
    //???????? ???????? ?? ???? ???? ??????? ???????
    $pattern='/'.$item['block_pattern'].'/iU';
    if (!preg_match ($pattern, $object)) continue;

    //? ?????????? ? ????? ????????? - module_object
    $item['module_object'] = $object;

    //???????? ??? ????? ? ?????? ?????????
    $block_content = appBlockRun($item);

    //? ??????????? ?? ?????????
    switch ($item['block_position'])
      {
      case 'l'://????? ?????
        array_push ($result_blocks['left'], $block_content);
        break;
      case 'r':
        array_push ($result_blocks['right'], $block_content);
        break;
      case 't':
        array_push ($result_blocks['top'], $block_content);
        break;
      case 'b':
        array_push ($result_blocks['bottom'], $block_content);
        break;
      case 'c':
        array_push ($result_blocks['center'], $block_content);
        break;
      }
    }
  
  //???????? ? ??????
  $myTpl->assign('blocks', $result_blocks);
  return true;
  }

function appBlockRun($block)
  {
  $result = array ();
  //????????? ???? ?????, ???? ?? ????, ???? ??? ?????? ??????
  $fname = "blocks/$block[block_name]/block.php";
  if (file_exists($fname))
    {
    include_once ($fname);
    }
  else
    {
    $result['block_displayname'] = '???? ?? ??????';
    $result['block_content'] = '???? ?? ??????';
    return $result;
    }
  //???? ??????? ??????????? ??????????? ?????? ?????
  $blockfunc = $block[block_name]."_display";

  if (function_exists($blockfunc))
    {
    $result = $blockfunc($block);
    if (!empty ($result['block_content']))
      {
      $result['id'] = $blockinfo['id'];
      $result = array_merge ($block, $result);
      }
    return $result;
    }
    else
      {
      $result['block_displayname'] = '???? ?? ??????';
      $result['block_content'] = '???? ?? ??????';
      return $result;
      }

  }

/************************* ???? **********************************/
function appWeightMax($table, $where='')
  {
  $db=DBConnector::getInstance();
  $db->query("SELECT MAX(weight) as max FROM $table $where");
  $result = $db->fetch_array();
  $maxweight = $result[0]['max'];
  return $maxweight;
  }

function appWeightUp($table, $weight, $where='')
  {
 
  if ($weight==1)
    return true;

  $where = str_replace('WHERE', '', $where);
  if ($where!='')
    {
    $where=" AND $where";
    };

  $db=DBConnector::getInstance();
  $next_weight = $weight--;
  $db->query("SELECT * FROM $table WHERE weight IN ('$weight', '$next_weight') $where ORDER BY weight LIMIT 2");
  $dbresult = $db->fetch_array();
 
  //????????????
  $dbresult[0][weight]++;
  $dbresult[1][weight]--;

  foreach ($dbresult as $newresult)
    $db->query("UPDATE $table SET weight = '$newresult[weight]' WHERE id = '$newresult[id]'");

  return true;
  }

function appWeightDown($table, $weight, $where='')
  {
  $MaxWeight=appWeightMax($table);
  if ($weight==$MaxWeight)
    return true;
  
  $where = str_replace('WHERE', '', $where);

  if ($where!='')
    {
    $where=" AND $where";
    };

  $db=DBConnector::getInstance();
  $next_weight = $weight++;
  $db->query("SELECT * FROM $table WHERE weight IN ('$weight', '$next_weight') $where ORDER BY weight LIMIT 2");
  $dbresult = $db->fetch_array();

  //????????????
  $dbresult[0][weight]++;
  $dbresult[1][weight]--;

  foreach ($dbresult as $newresult)
    $db->query("UPDATE $table SET weight = '$newresult[weight]' WHERE id = '$newresult[id]'");

  return true;
  }

function appWeightDelete($table, $weight, $where='')
  {
  $where = str_replace('WHERE', '', $where);
  
  if ($where!='')
    {
    $where=" AND $where";
    };

  $db=DBConnector::getInstance();
  $db->query("UPDATE $table SET weight = weight-1 WHERE weight >'$weight' $where");

  return true;
  }
 
  //////////////////////////////////////////////////////////////////////////////
  /////////  CACHE VARS                                               //////////
  //////////////////////////////////////////////////////////////////////////////
  
  /**
 * @desc �������� ����������
 * @return bool
 * @param component string ������ � �������� ��������� ����������
 * @param cacheKey string �����
 * @param value misc ��������
 */
function appVarSetCached($component, $cacheKey, $value=null, $ttl=null)
  {
  global $coreConfig;

  //Empty �������� � false
  if (!isset ($value)) $value = false;

	//�������� $cacheKey
	$cacheKey = $component.'_'.$cacheKey;

  //���������� ����� � ������
  $coreConfig[$cacheKey] = $value;

  //� ����������� �� ���� ��������� ��� � ������� ���������
  if ($coreConfig['Var.caching'] == 'disk')
    {
    $cacheKey_crc = (string)abs (crc32 ($cacheKey));
    $dir_way = './cache/vars/'.$cacheKey_crc[0].'/'.$cacheKey_crc[1].'/';
    if (!file_exists($dir_way)) 
      mkdir($dir_way, $coreConfig['default.dir.perms'], true);
    
    return (file_put_contents($dir_way.$cacheKey, serialize($value)));
    }
  elseif ($coreConfig['Var.caching'] == 'xcache')
    {
		if (!$ttl) $ttl = $coreConfig['Var.cache_lifetime'];
    return (xcache_set('appVar_'.$cacheKey, $value, $ttl));
    }
  elseif ($coreConfig['Var.caching'] == 'eaccelerator')
    {
		if (!$ttl) $ttl = $coreConfig['Var.cache_lifetime'];
    return (eaccelerator_put('appVar_'.$cacheKey, $value, $ttl));
    }
  elseif ($coreConfig['Var.caching'] == 'apc')
    {
		if (!$ttl) $ttl = $coreConfig['Var.cache_lifetime'];
    return (apc_store('appVar_'.$cacheKey, $value, $ttl));
    }

  return true;
  }

/**
 * @desc ��������� ���������� �� ����
 * @return misc �������� ����������
 * @param component string ������ � �������� ��������� ����������
 * @param cacheKey string �����
 */
function appVarGetCached($component, $cacheKey)
  {
  global $coreConfig;
	//�������� $cacheKey
	$cacheKey = $component.'_'.$cacheKey;

  //���� ���� ����� � ������ - ���������� �� ������
  if (isset($coreConfig[$cacheKey])) return $coreConfig['appVar_cache'][$cacheKey];

  //� ����������� �� ���� ��������� ��� �� �������� ���������
  if ($coreConfig['Var.caching'] == 'disk')
    {
    $cacheKey_crc = (string)abs(crc32($cacheKey));
    $file_way = './cache/vars/' . $cacheKey_crc[0] . '/' . $cacheKey_crc[1] . '/' . $cacheKey;
    if (file_exists($file_way))
      $coreConfig['appVar_cache'][$cacheKey] = unserialize(file_get_contents($file_way));
		    else return;
    }
  elseif ($coreConfig['Var.caching'] == 'xcache')
    {
    $coreConfig['appVar_cache'][$cacheKey] = xcache_get('appVar_' . $cacheKey);
    }
  elseif ($coreConfig['appConfig']['Var.caching'] == 'eaccelerator')
    {
    $coreConfig['appVar_cache'][$cacheKey] = eaccelerator_get('appVar_' . $cacheKey);
    }
  elseif ($coreConfig['Var.caching'] == 'apc')
    {
		$apc_value = apc_fetch('appVar_' . $cacheKey, $success);
		if ($success) $coreConfig['appVar_cache'][$cacheKey] = $apc_value;
    }

  if (isset($coreConfig['appVar_cache'][$cacheKey])) return $coreConfig['appVar_cache'][$cacheKey];
    else return;
  }

/**
 * @desc ��������� ������� ���������� � ����
 * @return bool
 * @param component string ������ � �������� ��������� ����������
 * @param cacheKey string �����
 */
function appVarIsCached($component, $cacheKey)
  {
  $cache_content = appVarGetCached($component, $cacheKey);
  if (isset($cache_content)) return true;
  return false;
  }

/**
 * @desc ������� ���������� �� ����
 * @return bool
 * @param component string ������ � �������� ��������� ����������
 * @param cacheKey string �����
 */
function appVarDelCached($component, $cacheKey)
  {
  global $coreConfig;
  
  if (!appVarIsCached($component, $cacheKey)) return true;

	//�������� $cacheKey
	$cacheKey = $component.'_'.$cacheKey;

  unset($coreConfig['appVar_cache'][$cacheKey]);
  //� ����������� �� ���� ���������� ���������� � ����
  if ($coreConfig['Var.caching'] == 'disk')
    {
    $cacheKey_crc = (string)abs(crc32($cacheKey));
    $file_way = './cache/vars/' . $cacheKey_crc[0] . '/' . $cacheKey_crc[1] . '/' . $cacheKey;
    @unlink($file_way);
    }
  elseif ($coreConfig['Var.caching'] == 'xcache')
    {
    xcache_unset('appVar_' . $cacheKey);
    }
  elseif ($coreConfig['Var.caching'] == 'eaccelerator')
    {
    eaccelerator_rm('appVar_' . $cacheKey);
    }
  elseif ($coreConfig['Var.caching'] == 'apc')
    {
    apc_delete('appVar_' . $cacheKey);
    }
  return true;
  }
  
function appTreeBuild($inArray, $start)
  {
  $result = array();
  $child_menu_list = array();
  foreach($inArray as $key=>$menu)
      {
      $child_menu_list[$menu['id']] = $menu;
      }
 
  appCreateTree($child_menu_list, $start, 0, -1, &$result); 
  
  return $result;
  //exit;
  }

function appCreateTree($array, $curParent, $currLevel = 0, $prevLevel = -1, $result) 
  {
  foreach ($array as $categoryId => $category) 
    {
    if ($curParent == $category['menu_parent_id']) 
      {
      $category['level'] = $currLevel;
      $result[$categoryId] = $category;
      if ($currLevel > $prevLevel) 
        { 
        $prevLevel = $currLevel;
        }

      $currLevel++;

      appCreateTree ($array, $categoryId, $currLevel, $prevLevel, &$result);

      $currLevel--;
      }

    }

}

function appCreateTreeHTML($array, $curParent, $currLevel = 0, $prevLevel = -1) 
  {
  foreach ($array as $categoryId => $category) 
    {
    if ($curParent == $category['parent_id']) 
      {
      if($category['parent_id']==0) 
        $class = "dropdown";
      else $class = "sub_menu";
      
      if ($currLevel > $prevLevel) 
        echo " <ul class='$class'> ";

      if ($currLevel == $prevLevel) 
        echo " </li> ";
  
      echo '<li id="'.$categoryId.'" >&lt;a href="'.$category['url'].'"&gt;'.$category['title'].'&lt;/a&gt;';

      if ($currLevel > $prevLevel) 
        { 
        $prevLevel = $currLevel;
        }

      $currLevel++;

      appCreateTree ($array, $categoryId, $currLevel, $prevLevel);

      $currLevel--;
      }

    }
if ($currLevel == $prevLevel) echo " </li> </ul> ";
}
?>