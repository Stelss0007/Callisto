<?php

function SYS_work_init()
  {
  //Создаем таблицу
  sysModClassLoad('SYS_df');
  $SYS_df = new SYS_df;

  $worktable = sysDBGetTable ('work');
  $SYS_df->CreateTable($worktable, array(
    'id' =>                array('type'        => 'int',
                                 'null'        => false,
                                 'default'     => '0',
                                 'increment'   => true,
                                 'primary_key' => true),

    'group_displayname' => array('type'        => 'varchar',
                                 'size'        => 60,
                                 'null'        => false,
                                 'default'     => ''),

    'group_description' => array('type'        => 'varchar',
                                 'size'        => 255,
                                 'null'        => false,
                                 'default'     => '')));

  //Регистрируем темплеи в системе
  sysModClassLoad('SYS_themes');
  $SYS_themes = new SYS_themes;

  $SYS_themes->tpl_add (array('tpl_compname'=>'SYS_work',
                              'tpl_name'=>'admin_main.tpl',
                              'tpl_pattern'=>'SYS_work::admin::main',
                              'tpl_description'=>'Главная админская страница'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'SYS_work',
                              'tpl_name'=>'admin_modify.tpl',
                              'tpl_pattern'=>'SYS_work::admin::modify',
                              'tpl_description'=>'Редактирование группы'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'SYS_work',
                              'tpl_name'=>'admin_confirm_delete.tpl',
                              'tpl_pattern'=>'SYS_work::admin::confirm_delete',
                              'tpl_description'=>'Подтверждение удаления группы'));

  // Initialisation successful
  return true;
  }

function SYS_work_upgrade($oldversion)
  {
  // Update successful
  return false;
  }

function SYS_work_delete()
  {
  // Deletion successful
  return false;
  }

function SYS_work_activate()
  {
  return true;
  }

function SYS_work_deactivate()
  {
  return false;
  }

?>