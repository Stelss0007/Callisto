<?php
function xcontent_block_add($blockinfo)
  {
  sysModClassLoad ('SYS_themes');
  $SYS_themes = new SYS_themes;

  //��������� ������, ���� ���� ���
  $sysObject = 'xcontent_block::display';
  $sysModTpl = sysTplWay ($sysObject);

  if (empty ($sysModTpl))
    {
    $SYS_themes->tpl_add (array('tpl_compname'=>'xcontent_block',
                                'tpl_name'=>'block_display.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'����� ���������� �����'));
    };

  //��������� ������, ���� ���� ���
  $sysObject = 'xcontent_block::modify';
  $sysModTpl = sysTplWay ($sysObject);
  if (empty ($sysModTpl))
    {
    $SYS_themes->tpl_add (array('tpl_compname'=>'xcontent_block',
                                'tpl_name'=>'block_modify.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'�������������� ���������� �����'));
    };

  return true;
  }

function xcontent_block_delete($blockinfo)
  {
  return true;
  }

function xcontent_block_activate($blockinfo)
  {
  //�������� ���������� �����
  $doc_count = sysBlockGetVar ($blockinfo['id'], 'doc_count');
  //�������� ���� ���� ������������ ������ ��� ���������� ���������� �� ���������.
  if ((empty ($doc_count)) && (!is_numeric ($doc_count)))
    {
    //������������� ����������
    sysBlockSetVar ($blockinfo['id'], 'doc_count', 10);
    sysBlockSetVar ($blockinfo['id'], 'folder_id', 0);
    sysBlockSetVar ($blockinfo['id'], 'include_subfolders', 1);
    sysBlockSetVar ($blockinfo['id'], 'doc_orderby', 'displayname');
    sysBlockSetVar ($blockinfo['id'], 'doc_order_asc', 1);
    sysBlockSetVar ($blockinfo['id'], 'block_ttl', 60);
    }
  return true;
  }

function xcontent_block_deactivate($blockinfo)
  {
  return true;
  };

function xcontent_block_modify($blockinfo)
  {
  if (!sysModAvailable ('content'))
    {//������ ����������
    return true;
    };

  //�������� ��� � ���� �������
  $sysObject = 'xcontent_block::modify::'.$blockinfo['id'];
  $sysModTpl = sysTplWay ($sysObject);
  $sysTpl = new sysTpl;
  $sysTpl->caching = 0;

  //�������� ���������� �����
  $doc_count = sysBlockGetVar ($blockinfo['id'],'doc_count');
  $folder_id = sysBlockGetVar ($blockinfo['id'],'folder_id');
  $include_subfolders = sysBlockGetVar ($blockinfo['id'],'include_subfolders');
  $doc_orderby = sysBlockGetVar ($blockinfo['id'],'doc_orderby');
  $doc_order_asc = sysBlockGetVar ($blockinfo['id'],'doc_order_asc');
  $block_ttl = sysBlockGetVar ($blockinfo['id'],'block_ttl');
  //�������� ���� ���� ������������� ������ ��� ���������� ���������� �� ���������.
  if ((empty ($doc_count)) && (!is_numeric ($doc_count)))
    {
    $doc_count = 10;
    $folder_id = 0;
    $include_subfolders = 0;
    $doc_orderby = 'displayname';
    $doc_order_asc = 1;
    $block_ttl = 60;
    //������������� ����������
    sysBlockSetVar ($blockinfo['id'], 'doc_count', $doc_count);
    sysBlockSetVar ($blockinfo['id'], 'folder_id', $folder_id);
    sysBlockSetVar ($blockinfo['id'], 'include_subfolders', $include_subfolders);
    sysBlockSetVar ($blockinfo['id'], 'doc_orderby', $doc_orderby);
    sysBlockSetVar ($blockinfo['id'], 'doc_order_asc', $doc_order_asc);
    sysBlockSetVar ($blockinfo['id'], 'block_ttl', $block_ttl);
    };

  //��������� ������
  sysModClassLoad ('content');
  $content = new content;
  $folders_list = $content->folder_ItemsTreeBuild(0,0);
  $sysTpl->assign('folders_list', $folders_list);

  //��������� ����� �� ������� ����� ����������� ���������� docfolder
  $docs_table = sysDBGetTable('content_docs');
  $docs_column = sysDBGetColumns($docs_table);
  $doc_orderslist = array();
  foreach ($docs_column as $key=>$value)
    {
    $doc_orderslist[$key]=$key;
    };
  unset ($doc_orderslist[parent_id]);
  unset ($doc_orderslist[fid]);
  unset ($doc_orderslist[content]);
  unset ($doc_orderslist[active]);
  $sysTpl->assign('doc_orders_list', $doc_orderslist);

  //�������� ���� ��������� � ������
  $sysTpl->assign('doc_count', $doc_count);
  $sysTpl->assign('folder_id', $folder_id);
  $sysTpl->assign('include_subfolders', $include_subfolders);
  $sysTpl->assign('doc_orderby', $doc_orderby);
  $sysTpl->assign('doc_order_asc', $doc_order_asc);
  $sysTpl->assign('block_ttl', $block_ttl);

  $result=$sysTpl->fetch($sysModTpl,$sysObject);
  return $result;
  };

function xcontent_block_update($blockinfo)
  {
  //�������� ���������� �������
  list ($doc_count, $folder_id, $include_subfolders, $doc_orderby, $doc_order_asc, $block_ttl) =
    sysVarCleanFromInput('doc_count', 'folder_id', 'include_subfolders', 'doc_orderby', 'doc_order_asc', 'block_ttl');

  //��� ����� ��������� ���� ������ 1
  if ($block_ttl<1)
    {
    $block_ttl=1;
    };

  sysBlockSetVar ($blockinfo['id'], 'doc_count', $doc_count);
  sysBlockSetVar ($blockinfo['id'], 'folder_id', $folder_id);
  sysBlockSetVar ($blockinfo['id'], 'include_subfolders', $include_subfolders);
  sysBlockSetVar ($blockinfo['id'], 'doc_orderby', $doc_orderby);
  sysBlockSetVar ($blockinfo['id'], 'doc_order_asc', $doc_order_asc);
  sysBlockSetVar ($blockinfo['id'], 'block_ttl', $block_ttl);
  //������� ��� ��������
  $sysTpl = new sysTpl;
  $sysTpl->clear_cache(null, 'xcontent_block::display');
  return true;
  };

?>