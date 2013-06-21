<?php

function anekdot_block_add($blockinfo)
  {
  //Добовляем шаблон, если нету еше
  sysModClassLoad ('SYS_themes');
  $SYS_themes = new SYS_themes;

  $sysObject = 'anekdot_block::display';
  $sysModTpl = sysTplWay ($sysObject);

  if (empty ($sysModTpl))
    {
    $SYS_themes->tpl_add (array('tpl_compname'=>'anekdot_block',
                                'tpl_name'=>'block_display.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'Вывод содержания блока'));
    };

  //Добовляем шаблон, если нету еше
  $sysObject = 'anekdot_block::modify';
  $sysModTpl = sysTplWay ($sysObject);
  if (empty ($sysModTpl))
    {
    $SYS_themes->tpl_add (array('tpl_compname'=>'anekdot_block',
                                'tpl_name'=>'block_modify.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'Редактирование блока'));
    };

  return true;
  }

function anekdot_block_delete($blockinfo)
  {
  return true;
  }

function anekdot_block_activate($blockinfo)
  {
  return true;
  }

function anekdot_block_deactivate($blockinfo)
  {
  return true;
  }

function anekdot_block_modify($blockinfo)
  {
  //Прелюдие как у всех модулей
  /*
  $sysObject = 'anekdot_block::modify::'.$blockinfo[id];
  $sysModTpl=sysTplWay ($sysObject);
  $sysTpl = new sysTpl;
  $sysTpl->caching = false;

  //Содержание
  $content = sysBlockGetVar ($blockinfo['id'], 'content');
  $sysTpl->assign('content', $content);

  $result = $sysTpl->fetch($sysModTpl,$sysObject);
  return $result;
  */
  }

function anekdot_block_update($blockinfo)
  {
  /*
  //Забираем переменные совхода
  //Переменная не очишенная, может содержать JAVA !!!!
  $content = sysVarGetFromInput('content'); //Лутчше не делайте так
  sysBlockSetVar ($blockinfo['id'], 'content', $content);
  //Очищаем кеш шаблонов
  $sysTpl = new sysTpl;
  $sysTpl->clear_cache(null, 'anekdot_block::display');
  return true;
  */
  }

?>