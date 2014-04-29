<?php
function userlogin_block_display($blockinfo)
  {
  print_r($blockinfo);
  //Прелюдие как у всех блоков
  $sysObject = 'userlogin_block::display'.$blockinfo['id'];

  //Проверка на доступ
  //if (!coreSecAuthAction($sysObject, ACCESS_READ)) return true;


//  if (sysUserIsLoggedIn())
//    {//Уже залогинен
//    return true;
//    }
//    else
//      {
//      $sysModTpl = sysTplWay ($sysObject);
//      $sysTpl = new sysTpl;
//      $sysTpl->cache_lifetime = -1;
//
//      //Прверка в кеше
//      if($sysTpl->is_cached($sysModTpl, $sysObject))
//        {
//        //Возвращаем результат
//        $result['block_content'] =& $sysTpl->fetch($sysModTpl, $sysObject);
//        return $result;
//        };
//
//      //ВЫводим содержание блока
//      $result['block_content'] =& $sysTpl->fetch($sysModTpl, $sysObject);
//      return $result;
//      };
  return "aaaaa";
  } 
?>