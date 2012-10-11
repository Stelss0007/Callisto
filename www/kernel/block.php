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
    /************************** Блоки  *******************************/
  //Соберем все блоки и приготовим к отображению по своим местам

  function blockShowAll(&$myTpl, &$object)
    {
    $db=DBConnector::getInstance();
    $ses_info=UserSession::getInstance();
    $db->query("SELECT * FROM blocks WHERE block_active = '1' ORDER BY block_position, weight");
    $db_block_list = $db->fetch_array();
  //  echo 'Результат значений:<br><pre>';
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
      //Проверим подходит ли этот блок данному объекту
      $pattern='/'.$item['block_pattern'].'/iU';
      if (!preg_match ($pattern, $object)) continue;

      //В информацию о блоке добавляем - module_object
      $item['module_object'] = $object;

      //Выполним код блока и вернем результат
      $block_content = blockRun($item);

      //В зависимости от положения
      switch ($item['block_position'])
        {
        case 'l'://Левые блоки
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

    //Загоняем в шаблон
    $myTpl->assign('blocks', $result_blocks);
    return true;
    }

  function blockRun($block)
    {
    $result = array ();
    //Подключим файл блока, если он есть, если нет вернем ошибку
    $fname = "blocks/$block[block_name]/block.php";
    if (file_exists($fname))
      {
      include_once ($fname);
      }
    else
      {
      $result['block_displayname'] = 'Блок не найден';
      $result['block_content'] = 'Блок не найден';
      return $result;
      }
    //Ищем функцию отображения результатов работы блока
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
        $result['block_displayname'] = 'Блок не найден';
        $result['block_content'] = 'Блок не найден';
        return $result;
        }

    }
  }
?>
