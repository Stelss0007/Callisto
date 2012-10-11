<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of block
 *
 * @author Your Name <your.name at your.org>
 */
class Block
  {
    /************************** �����  *******************************/
  //������� ��� ����� � ���������� � ����������� �� ����� ������

  function blockShowAll(&$myTpl, &$object)
    {
    $db=DBConnector::getInstance();
    $ses_info=UserSession::getInstance();
    $db->query("SELECT * FROM blocks WHERE block_active = '1' ORDER BY block_position, weight");
    $db_block_list = $db->fetch_array();
  //  echo '��������� ��������:<br><pre>';
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
      //�������� �������� �� ���� ���� ������� �������
      $pattern='/'.$item['block_pattern'].'/iU';
      if (!preg_match ($pattern, $object)) continue;

      //� ���������� � ����� ��������� - module_object
      $item['module_object'] = $object;

      //�������� ��� ����� � ������ ���������
      $block_content = blockRun($item);

      //� ����������� �� ���������
      switch ($item['block_position'])
        {
        case 'l'://����� �����
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

    //�������� � ������
    $myTpl->assign('blocks', $result_blocks);
    return true;
    }

  function blockRun($block)
    {
    $result = array ();
    //��������� ���� �����, ���� �� ����, ���� ��� ������ ������
    $fname = "blocks/$block[block_name]/block.php";
    if (file_exists($fname))
      {
      include_once ($fname);
      }
    else
      {
      $result['block_displayname'] = '���� �� ������';
      $result['block_content'] = '���� �� ������';
      return $result;
      }
    //���� ������� ����������� ����������� ������ �����
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
        $result['block_displayname'] = '���� �� ������';
        $result['block_content'] = '���� �� ������';
        return $result;
        }

    }
  }
?>
