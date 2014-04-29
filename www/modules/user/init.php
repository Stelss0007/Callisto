<?php

function content_init()
  {
  sysModClassLoad ('SYS_df');
  $SYS_df = new SYS_df;
  sysModClassLoad ('SYS_themes');
  $SYS_themes = new SYS_themes();

  //Создаем таблицу папак
  $folders_table = sysDBGetTable ('content_folders');
  $SYS_df->CreateTable($folders_table, array(
    'id' =>                   array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => '1',
                                    'increment'   => true,
                                    'primary_key' => true),

    'parent_id' =>            array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => '0',
                                    'index'       => true),

    'weight'=>                array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => '0',
                                    'index'       => true),

    'uid'=>                   array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => -1,
                                    'index'       => true),

    'active' =>               array('type'        => 'tinyint',
                                    'size'        => 1,
                                    'null'        => false,
                                    'default'     => 0,
                                    'index'       => true),

    'counter' =>              array('type'        => 'int',
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => 1),

    'subdoc_counter' =>       array('type'        => 'int',
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => 0),

    'subfolder_counter' =>    array('type'        => 'int',
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => 0),

    'subfolder_orderby' =>    array('type'        => 'varchar',
                                    'size'        => 20,
                                    'null'        => false,
                                    'default'     => 'displayname'),

    'subfolder_order_asc' =>  array('type'        => 'tinyint',
                                    'size'        => 1,
                                    'null'        => false,
                                    'default'     => 1),

    'subdoc_orderby' =>       array('type'        => 'varchar',
                                    'size'        => 20,
                                    'null'        => false,
                                    'default'     => 'displayname'),

    'subdoc_order_asc' =>     array('type'        => 'tinyint',
                                    'size'        => 1,
                                    'null'        => false,
                                    'default'     => 1),

    'subdoc_perpage_user' =>  array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => 10),

    'subdoc_perpage_admin' => array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => 100),

    'limit_doc_perfolder' =>  array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => 0),

    'limit_doc_olderdays' =>  array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => 0),

    'need_admin_active' =>    array('type'        => 'tinyint',
                                    'size'        => 1,
                                    'null'        => false,
                                    'default'     => 1),

    'mailon_docs_change' =>   array('type'        => 'tinyint',
                                    'size'        => 1,
                                    'null'        => false,
                                    'default'     => 1),

    'displayname' =>          array('type'        => 'varchar',
                                    'size'        => 128,
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'index'      => true,
                                    'default'     => ''),

    'description' =>          array('type'        => 'text',
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => ''),

    'content' =>              array('type'        => 'mediumtext',
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => ''),

    'logo' =>                 array('type'        => 'varchar',
                                    'size'        => 255,
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => '')));

  //Создаем таблицу документов
  $docs_table = sysDBGetTable ('content_docs');
  $SYS_df->CreateTable($docs_table, array(
    'id' =>                   array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => '1',
                                    'increment'   => true,
                                    'primary_key' => true),

    'fid' =>                  array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => '0',
                                    'index'       => true),

    'parent_id' =>            array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => '0',
                                    'index'       => true),

    'weight'=>                array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => '0',
                                    'index'       => true),

    'uid'=>                   array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => -1,
                                    'index'       => true),

    'active' =>               array('type'        => 'tinyint',
                                    'size'        => 1,
                                    'null'        => false,
                                    'default'     => 0,
                                    'index'       => true),

    'doc_subdoc_counter' =>   array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => 0,
                                    'index'       => true),

    'pub_datetime' =>         array('type'        => 'datetime',
                                    'null'        => false,
                                    'default'     => '',
                                    'canmodify'   => true,
                                    'index'       => true),

    'counter' =>              array('type'        => 'int',
                                    'null'        => false,
                                    'default'     => 1,
                                    'canmodify'   => true,
                                    'index'       => true),

    'from_ip' =>              array('type'        => 'varchar',
                                    'size'        => 20,
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => ''),

    'displayname' =>          array('type'        => 'varchar',
                                    'size'        => 255,
                                    'null'        => false,
                                    'default'     => '',
                                    'canmodify'   => true,
                                    'fulltext'    => true,
                                    'index'      => true),

    'description' =>          array('type'        => 'text',
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => '',
                                    'fulltext'    => true),

    'content' =>              array('type'        => 'mediumtext',
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'fulltext'    => true,
                                    'default'     => ''),

    'url' =>                  array('type'        => 'varchar',
                                    'size'        => 255,
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => ''),

    'url_counter' =>          array('type'        => 'int',
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => 1),

    'author' =>               array('type'        => 'varchar',
                                    'size'        => 120,
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => ''),

    'author_email' =>         array('type'        => 'varchar',
                                    'size'        => 60,
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => ''),

    'logo' =>                 array('type'        => 'varchar',
                                    'size'        => 255,
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => ''),

    'misc_varchar_a' =>       array('type'        => 'varchar',
                                    'size'        => 255,
                                    'null'        => false,
                                    'canmodify'   => true,
                                    'default'     => '')));

  ////////////////////////////////////////////////////////////////////////////////
  ///////////////  Загрузка данных по умолчанию в базу  //////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  //$sql = implode ('', file ('modules/content/install/content_folders.sql'));
  $folders_table = sysDBGetTable('content_folders');

  $sql="INSERT INTO `$folders_table` VALUES (1, 0, 1, 1, 1, 1, 2, 0, 'displayname', 1, 'pub_datetime', 0, 20, 100, 0, 0, 1, 1, 'Новости', '', '', '')";
  mysql_query($sql);
  $sql="INSERT INTO `$folders_table` VALUES (2, 0, 2, 1, 1, 1, 1, 0, 'displayname', 1, 'displayname', 1, 20, 100, 0, 0, 1, 1, 'Документы', '', '', '')";
  mysql_query($sql);
  $sql="INSERT INTO `$folders_table` VALUES (3, 0, 3, 1, 0, 1, 1, 0, 'displayname', 1, 'displayname', 1, 20, 100, 0, 0, 1, 1, 'Спец секция', '', '', '')";
  mysql_query($sql);
  $sql="INSERT INTO `$folders_table` VALUES (4, 0, 4, 1, 1, 1, 0, 0, 'displayname', 1, 'displayname', 1, 20, 100, 0, 0, 1, 1, 'Файлы', '', '', '')";
  mysql_query($sql);
  $sql="INSERT INTO `$folders_table` VALUES (5, 0, 5, 1, 1, 1, 0, 0, 'displayname', 1, 'displayname', 1, 20, 100, 0, 0, 1, 1, 'Web ссылки', '', '', '')";
  mysql_query($sql);
  $sql="INSERT INTO `$folders_table` VALUES (6, 0, 6, 1, 1, 1, 0, 0, 'displayname', 1, 'displayname', 1, 20, 100, 0, 0, 1, 1, 'FAQ', '', '', '')";
  mysql_query($sql);
  $sql="INSERT INTO `$folders_table` VALUES (7, 0, 7, 1, 1, 1, 0, 0, 'displayname', 1, 'pub_datetime', 0, 20, 100, 0, 0, 1, 1, 'Доска объявлений', '', '', '')";
  mysql_query($sql);
  $sql="INSERT INTO `$folders_table` VALUES (8, 0, 8, 1, 1, 1, 0, 0, 'displayname', 1, 'pub_datetime', 0, 20, 100, 0, 0, 1, 1, 'Гостевая книга', '', '', '')";
  mysql_query($sql);
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////  Шаблоны  /////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////

  //Регистрируем темплеи в системе сначала шаблоны просмотра
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'user_main.tpl',
                              'tpl_pattern'=>'content::user::main',
                              'tpl_description'=>'Главная страница'));


  //Шаблоны для новостей
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'news/user_folder_view.tpl',
                              'tpl_pattern'=>'^content::user::folder::view::1(::|$)',
                              'tpl_description'=>'Просмотр списка новостей'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'news/user_doc_view.tpl',
                              'tpl_pattern'=>'^content::user::doc::view::1(::|$)',
                              'tpl_description'=>'Просмотр новости'));

  //Шаблоны для файлов
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'files/user_folder_view.tpl',
                              'tpl_pattern'=>'^content::user::folder::view::4(::|$)',
                              'tpl_description'=>'Просмотр списка файлов'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'files/user_doc_view.tpl',
                              'tpl_pattern'=>'^content::user::doc::view::4(::|$)',
                              'tpl_description'=>'Просмотр файла'));


  //Шаблоны для веб ссылок
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'weblinks/user_folder_view.tpl',
                              'tpl_pattern'=>'^content::user::folder::view::5(::|$)',
                              'tpl_description'=>'Просмотр списка веб ссылок'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'weblinks/user_doc_view.tpl',
                              'tpl_pattern'=>'^content::user::doc::view::5(::|$)',
                              'tpl_description'=>'Просмотр веб ссылок'));


  //Шаблоны для faq
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'faq/user_folder_view.tpl',
                              'tpl_pattern'=>'^content::user::folder::view::6(::|$)',
                              'tpl_description'=>'Просмотр faq'));


  //Шаблоны для доски обьявлений
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'board/user_folder_view.tpl',
                              'tpl_pattern'=>'^content::user::folder::view::7(::|$)',
                              'tpl_description'=>'Просмотр списка обьявлений'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'board/user_doc_view.tpl',
                              'tpl_pattern'=>'^content::user::doc::view::7(::|$)',
                              'tpl_description'=>'Просмотр обьявления'));


  //Шаблоны для gb
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'gb/user_folder_view.tpl',
                              'tpl_pattern'=>'^content::user::folder::view::8(::|$)',
                              'tpl_description'=>'Просмотр гостевой книги'));


  //Шаблоны документов
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'user_folder_view.tpl',
                              'tpl_pattern'=>'content::user::folder::view',
                              'tpl_description'=>'Просмотр папки'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'user_doc_view.tpl',
                              'tpl_pattern'=>'content::user::doc::view',
                              'tpl_description'=>'Просмотр документа'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'user_subdoc_view.tpl',
                              'tpl_pattern'=>'content::user::subdoc::view',
                              'tpl_description'=>'Просмотр страницы'));

  ////////////////////////////////////////////////////////////////////////////////
  /////////////   Административная часть (шаблоны добавления и т.д.)  ////////////
  ////////////////////////////////////////////////////////////////////////////////

  // Новости
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'news/admin_doc_new.tpl',
                              'tpl_pattern'=>'^content::admin::doc::new::1(::|$)',
                              'tpl_description'=>'Создание новости'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'news/admin_doc_modify.tpl',
                              'tpl_pattern'=>'^content::admin::doc::modify::1(::|$)',
                              'tpl_description'=>'Редактирование новости'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'news/admin_doc_copy_dg.tpl',
                              'tpl_pattern'=>'^content::admin::doc::copy_dg::1(::|$)',
                              'tpl_description'=>'Копирование новости'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'news/admin_doc_confirm_delete.tpl',
                              'tpl_pattern'=>'^content::admin::doc::confirm_delete::1(::|$)',
                              'tpl_description'=>'Подтверждение удаления новости'));

  // файлы
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'files/admin_doc_new.tpl',
                              'tpl_pattern'=>'^content::admin::doc::new::4(::|$)',
                              'tpl_description'=>'Добавление файла'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'files/admin_doc_modify.tpl',
                              'tpl_pattern'=>'^content::admin::doc::modify::4(::|$)',
                              'tpl_description'=>'Редактирование файла'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'files/admin_doc_copy_dg.tpl',
                              'tpl_pattern'=>'^content::admin::doc::copy_dg::4(::|$)',
                              'tpl_description'=>'Копирование файла'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'files/admin_doc_confirm_delete.tpl',
                              'tpl_pattern'=>'^content::admin::doc::confirm_delete::4(::|$)',
                              'tpl_description'=>'Подтверждение удаления файла'));


  // weblinks
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'weblinks/admin_doc_new.tpl',
                              'tpl_pattern'=>'^content::admin::doc::new::5(::|$)',
                              'tpl_description'=>'Добавление ссылки'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'weblinks/admin_doc_modify.tpl',
                              'tpl_pattern'=>'^content::admin::doc::modify::5(::|$)',
                              'tpl_description'=>'Редактирование ссылки'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'weblinks/admin_doc_copy_dg.tpl',
                              'tpl_pattern'=>'^content::admin::doc::copy_dg::5(::|$)',
                              'tpl_description'=>'Копирование ссылки'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'weblinks/admin_doc_confirm_delete.tpl',
                              'tpl_pattern'=>'^content::admin::doc::confirm_delete::5(::|$)',
                              'tpl_description'=>'Подтверждение удаления ссылки'));

  // faq
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'faq/admin_doc_new.tpl',
                              'tpl_pattern'=>'^content::admin::doc::new::6(::|$)',
                              'tpl_description'=>'Добавление faq'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'faq/admin_doc_modify.tpl',
                              'tpl_pattern'=>'^content::admin::doc::modify::6(::|$)',
                              'tpl_description'=>'Редактирование faq'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'faq/admin_doc_copy_dg.tpl',
                              'tpl_pattern'=>'^content::admin::doc::copy_dg::6(::|$)',
                              'tpl_description'=>'Копировать faq'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'faq/admin_doc_confirm_delete.tpl',
                              'tpl_pattern'=>'^content::admin::doc::confirm_delete::6(::|$)',
                              'tpl_description'=>'Подтверждение удаления faq'));

  // board
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'board/admin_doc_new.tpl',
                              'tpl_pattern'=>'^content::admin::doc::new::7(::|$)',
                              'tpl_description'=>'Добавление обьявления'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'board/admin_doc_modify.tpl',
                              'tpl_pattern'=>'^content::admin::doc::modify::7(::|$)',
                              'tpl_description'=>'Редактирование обьявления'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'board/admin_doc_confirm_delete.tpl',
                              'tpl_pattern'=>'^content::admin::doc::confirm_delete::7(::|$)',
                              'tpl_description'=>'Подтверждение удаления обьявления'));


  // gb
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'gb/admin_doc_new.tpl',
                              'tpl_pattern'=>'^content::admin::doc::new::8(::|$)',
                              'tpl_description'=>'Добавление записи'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'gb/admin_doc_modify.tpl',
                              'tpl_pattern'=>'^content::admin::doc::modify::8(::|$)',
                              'tpl_description'=>'Редактирование записи'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'gb/admin_doc_confirm_delete.tpl',
                              'tpl_pattern'=>'^content::admin::doc::confirm_delete::8(::|$)',
                              'tpl_description'=>'Подтверждение удаление записи'));





  //Создание разделов, везде одинаковое
  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_folder_new.tpl',
                              'tpl_pattern'=>'content::admin::folder::new',
                              'tpl_description'=>'Создание новой папки'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_folder_modify.tpl',
                              'tpl_pattern'=>'content::admin::folder::modify',
                              'tpl_description'=>'Редактирование папки'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_folder_copy_dg.tpl',
                              'tpl_pattern'=>'content::admin::folder::copy_dg',
                              'tpl_description'=>'Копирование папки'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_folder_confirm_delete.tpl',
                              'tpl_pattern'=>'content::admin::folder::confirm_delete',
                              'tpl_description'=>'Подтверждение удаления папки'));





  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_doc_new.tpl',
                              'tpl_pattern'=>'content::admin::doc::new',
                              'tpl_description'=>'Создание нового документа'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_doc_modify.tpl',
                              'tpl_pattern'=>'content::admin::doc::modify',
                              'tpl_description'=>'Редактирование документа'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_doc_copy_dg.tpl',
                              'tpl_pattern'=>'content::admin::doc::copy_dg',
                              'tpl_description'=>'Копирование документа'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_doc_confirm_delete.tpl',
                              'tpl_pattern'=>'content::admin::doc::confirm_delete',
                              'tpl_description'=>'Подтверждение удаления документа'));



  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_subdoc_new.tpl',
                              'tpl_pattern'=>'content::admin::subdoc::new',
                              'tpl_description'=>'Создание нового документа вложенного в документ'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_subdoc_modify.tpl',
                              'tpl_pattern'=>'content::admin::subdoc::modify',
                              'tpl_description'=>'Редактированние документа вложенного в документ'));

  $SYS_themes->tpl_add (array('tpl_compname'=>'content',
                              'tpl_name'=>'admin_subdoc_confirm_delete.tpl',
                              'tpl_pattern'=>'content::admin::subdoc::confirm_delete',
                              'tpl_description'=>'Подтверждение удаления документа в документе'));

  // Initialisation successful
  return true;
  }

function content_upgrade($oldversion)
  {
  // Update successful
  return false;
  }

function content_delete()
  {
  // Deletion successful
  return true;
  }


function content_activate()
  {
  return true;
  }

function content_deactivate()
  {
  return true;
  }

?>