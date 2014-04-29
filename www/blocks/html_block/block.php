<?php

function html_block_display(&$blockinfo)
  {
  //Прелюдие как у всех блоков
  $sysObject = 'html_block::display::'.$blockinfo['id'];

  //Проверка на доступ
  if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;

  $sysTpl = new sysTpl;
  $sysTpl->cache_lifetime = -1;
  $sysModTpl = sysTplWay ($sysObject);

  if($sysTpl->is_cached($sysModTpl, $sysObject))
    {
    //Возвращаем результат
    $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
    return $result;
    };

  //Содержание
  $content =& sysBlockGetVar ($blockinfo['id'], 'content');
  $sysTpl->assign('content', $content);

  //Название блока
  $sysTpl->assign('block_displayname', $blockinfo['block_displayname']);

  $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
  return $result;
  }

?>