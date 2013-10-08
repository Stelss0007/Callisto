<?php
function menu_block_display($info)
  {
  $menu_config = unserialize($info['block_content']);
//	//������ ��������?
//  if (!sysModAvailable ('menu')) return true;
//
//	//��� ���������� � ��� ��� ��������?
//  if (empty ($info['block_content'])) return true;

  //���������� �����
//  $parent_id = (int)sysBlockGetVar ($info[id], 'parent_id');
//  $menu_type = sysBlockGetVar ($info[id], 'menu_type');
  $sysTpl = new coreTpl;
  $sysTpl->cache_lifetime = -1;

  //��������� ������ ��������
  //��������� ���� ���� � ���� ����� �� ����
	//$items_list = sysVarGetCached('menu', 'menu_tree_'.$parent_id.'_-1_'.true);
  $parent_id=$menu_config['parent_id'];
  $menu_type=1;
  if (!$items_list)
		{
		appModClassLoad ('menu');
		$menu = new menu;
		$items_list = $menu->menuTree($parent_id, -1, true);
		//sysVarSetCached('menu', 'menu_tree_'.$parent.'_id_-1_'.true, $items_list);
		}

  //���� �����, ������ ���� ��� �� ��������
  if (!$items_list) return true;

  // ���������� id �������� ��������
  global $HTTP_SERVER_VARS;
  $cur_uri = $HTTP_SERVER_VARS['REQUEST_URI'];

  $cur_item_id = 0;
  foreach ($items_list as $item)
    {
    if ($item['item_type']==3 && $cur_uri==$item['content'])
      {
      $cur_item_id = $item['id'];
      break;
      }
    }

  //������������� 2 ������ ��� ���� 1 ��� 2

  //��� 1 - ������� �����������
  if ($menu_type==1)
    {
    $tpl = tplInfo(__FUNCTION__, __FILE__);
    //$sysObject = 'menu_block::display::'.$info['id'].'::'.$cur_item_id;
    //�������� �� ������
    //if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;

//    $sysModTpl = sysTplWay ($sysObject);
//    if ($sysTpl->is_cached ($sysModTpl, $sysObject))
//      {
//      //����������
//      $result['block_object'] =& $sysObject;
//      $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
//      return $result;
//      };

    }

  //HTML 4.01 � ��� ��� � �� ����, ������ ���������������
  foreach ($items_list as $key=>$value)
    {
    if ($value['item_type']==3)
      {
      $items_list[$key]['content'] = str_replace('&', '&amp;', $value['content']);
      }
    }

  $sysTpl->assign($info);
  $sysTpl->assign('unwrap_item_id', $unwrap_item_id);
  $sysTpl->assign('cur_item_id', $cur_item_id);
  $sysTpl->assign('items_list', $items_list);
  $result['block_content'] = $sysTpl->fetch($tpl['src'],$tpl['object']);
  return $result;
  }


function menu_block_modify($info)
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  $smarty = new coreTpl();
  $smarty->caching = false;

  appModClassLoad ('menu');
  $menu = new menu;

  $menu_config = unserialize($info['block_content']);
  
  //������� �������
  $smarty->assign('parent_id', $menu_config['parent_id']);

  $items_list = $menu->menuTree(0, 0);
  $smarty->assign('items_list', $items_list);

  
  return $smarty->fetch($tpl['src'],$tpl['object']);
  }

function menu_block_update($info)
  {
  $menu_config['parent_id'] = appCleanFromInput('parent_id');
  $menu_config = serialize($menu_config);

  $db=DBConnector::getInstance();
  $db->query("UPDATE blocks SET block_content='%s' WHERE id='%d'", $menu_config, $info['id']);
  }

?>