<?php

function xcontent_block_display($blockinfo)
  {
  if (!sysModAvailable ('content'))
    {//Модуль недоступен
    return true;
    };

  //Забираем переменные блока
  $folder_id = sysBlockGetVar ($blockinfo[id],'folder_id');
  $block_ttl = sysBlockGetVar ($blockinfo[id],'block_ttl');

  if (!is_numeric($folder_id))
    {
    $folder_id=0;
    };

  //Строим имя и опредиляем если нужно текущий раздел
  if ($folder_id>=0)
    {
    $sysObject = 'xcontent_block::display::'.$blockinfo['id'];
    }
    else
      {//Опредиляем текущий раздел
      list($module,
           $func,
           $type) = sysVarCleanFromInput('module',
                                         'func',
                                         'type');
      //Проверка эт content ?
      if ($module!='content')
        {
        //Выходим
        return true;
        }
        elseif ($func=='folder_view')
          {
          $folder_id = sysVarCleanFromInput('id');
          $sysObject = 'xcontent_block::display::'.$blockinfo['id'].'::'.$folder_id;
          }
          elseif ($func=='doc_view')
            {
            $folder_id = sysVarCleanFromInput('fid');
            $sysObject = 'xcontent_block::display::'.$blockinfo['id'].'::'.$folder_id;
            }
            elseif ($func=='subdoc_view')
              {
              $folder_id = sysVarCleanFromInput('fid');
              $sysObject = 'xcontent_block::display::'.$blockinfo['id'].'::'.$folder_id;
              }
              elseif (($func=='main') && ($type=='user'))
                {
                $folder_id = 0;
                $sysObject = 'xcontent_block::display::'.$blockinfo['id'].'::'.$folder_id;
                }
                else
                  {
                  //Неповезло, не определили, выходим
                  return true;
                  }
      }

  ////////////////////////////////////////////////////////////////////////////////
  //Все с именнами разобрались
  //Проверка на доступ
  if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;

  $sysTpl = new sysTpl;
  $sysModTpl = sysTplWay ($sysObject);
  $sysTpl->caching = true;
  $sysTpl->cache_lifetime = ($block_ttl*60);

  if($sysTpl->is_cached($sysModTpl,$sysObject))
    {
    //Возвращаем
    $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
    return $result;
    };

  //переменные блока
  $doc_count = sysBlockGetVar ($blockinfo['id'], 'doc_count');
  $include_subfolders = sysBlockGetVar ($blockinfo['id'], 'include_subfolders');
  $doc_orderby = sysBlockGetVar ($blockinfo['id'], 'doc_orderby');
  $doc_order_asc = sysBlockGetVar ($blockinfo['id'], 'doc_order_asc');
  if (!is_numeric($doc_count))
    $doc_count = 10;
  if (empty($doc_orderby))
    $doc_orderby = 'displayname';

  //Так теперь делаем выборку

  //Берем вложенные документы
  $docs_table = sysDBGetTable('content_docs');
  $docs_column =  sysDBGetColumns($docs_table);

  //Учитываем  limit_doc_olderdays  limit_doc_perfolder
  $now = date("Y-m-d H:i:00");

  //Получили список вложенных документов
  //Сортировать по возрастанию / убыванию
  if (sysBlockGetVar ($blockinfo['id'],'doc_order_asc'))
    $order=' ASC';
    else
      $order=' DESC';

  $where = "$docs_column[fid] = '$folder_id'";
  //Включать подразделы или нет ?
  if ($include_subfolders)
    {
    //Если включать значит выстраиваем дерево
    sysModClassLoad ('content');
    $content = new content;
    $folders_list = $content->folder_ItemsTreeBuild($folder_id, 0);
    foreach ($folders_list as $folder)
      $where .= " OR $docs_column[fid] = '$folder[id]'";
    }

  //Собственно выборка
  $docs_list = sysDbSelect ($docs_table, $docs_column,
    "WHERE ($where) AND $docs_column[active]=1
       AND $docs_column[pub_datetime]<'$now'
       AND $docs_column[parent_id] = 0
       ORDER BY $doc_orderby $order
         LIMIT 0, $doc_count", true);

  //Если нет документов, блок невыводим вообще
  //if (empty ($docs_list))
	//    return true;

  //С документами все Загоняем в шаблон
  $sysTpl->assign('docs_list', $docs_list);

  //Назначяем переменные (настройки блока)
  $sysTpl->assign('doc_count', $doc_count);
  $sysTpl->assign('include_subfolders', $include_subfolders);
  $sysTpl->assign('doc_orderby', $doc_orderby);
  $sysTpl->assign('doc_order_asc', $doc_order_asc);

  //Информацию о блоке
  $sysTpl->assign('blockinfo', $blockinfo);

  //The End
  $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
  return $result;
  }


?>