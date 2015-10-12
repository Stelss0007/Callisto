<?php

/*
 * Smarty plugin
 *
 * $paging_show_text      - Флаг описания постранички (1), например "Страница (1/10):"
 * $paging_text           - Текст описания постранички. Например "Страница: (%%page%%/%%page_total%%)"
 *                          Список переменных: %%page%% , %%element_at_page%% , %%element_start_num%% , %%element_total_count%% , %%element_end_num%% , %%page_total%%
 * $paging_element_count  - Количество отображаемых элементов постранички. Например: < 1 2 3 4 5 6 7 8 9 10 11 >  здесь поумолчанию отображается 11 элементов, 
 *                          хотя страниц допустим 15, все остальные прячутся
 * 
 * $paging_show_last_first- Флаг отображения кнопок 'Первая' и 'Последняя'
 * $paging_show_number    - Флаг отображения кнопок с номерами страниц '1 2 3 4 5 ...'
 * 
 * $paging_first          - Текст кнопки 'Первая'
 * $paging_last           - Текст кнопки 'Последняя'
 * $paging_prev           - Текст кнопки '«'
 * $paging_next           - Текст кнопки '»'

  {pagination show_paging_text='1' paging_text='Страница: (%%page%%/%%page_total%%)' }
 */

function smarty_function_pagination($params, &$smarty)
  {
  extract($params);
  extract($smarty->getTemplateVars('pagination'));
  
  //Default values
  if(!isset($paging_show_text))       $paging_show_text = 1;
  if(!isset($paging_show_last_first)) $paging_show_last_first = 1;
  if(!isset($paging_show_number))     $paging_show_number = 1;
  if(!isset($paging_text))            $paging_text = $smarty->getConfigVars('sys_pagination_text');   // -> "Страницы: (%%page%%/%%page_total%%)";
  if(!isset($paging_first))           $paging_first = $smarty->getConfigVars('sys_pagination_first'); // -> "Первая";
  if(!isset($paging_last))            $paging_last = $smarty->getConfigVars('sys_pagination_last');   // -> "Последняя";
  if(!isset($paging_prev))            $paging_prev = $smarty->getConfigVars('sys_pagination_prev');   // -> "«";
  if(!isset($paging_next))            $paging_next = $smarty->getConfigVars('sys_pagination_next');   // -> "»";
  if(!isset($paging_element_count))   $paging_element_count = 7;
  

  $url = appCurPageURL();
  $url = appUpdateUrlQuery($url, array('page' => ''));

  $paging_element_count--;
  
  if($paging_element_count > $page_total)
    {
    $paging_element_count = $page_total;
    }


  $result = '<div class="pagination">';
  
  if($paging_show_text && ($page_total > 1)) 
    {
    //$result .= "<div class='pagination-info'><b>Страницы: ({$page}/{$page_total}) </b></div>";
    $result .= "<div class='pagination-info'><b>".  appStrReplaceTemplate($paging_text, $smarty->getTemplateVars('pagination'))." </b></div>";
    }
    
  $result .= "<ul class='pagination-items pagination'>";

  if($page_total > 1)
    {
    $page_prev = $page - 1;
    if($page_prev == 0) //на первую страницу номер не включаем
      {
      $result .= ($paging_show_last_first) ? "<li class='disabled'><a href='#'>$paging_first</a></li>" : '';
      $result .= "<li class='disabled'><a href='#'>$paging_prev</a></li>";
      }
    else
      {
      $result .= ($paging_show_last_first) ? "<li><a href='{$url}1'>$paging_first</a></li>" : '';
      $result .= "<li><a href='$url$page_prev'>$paging_prev</a></li>";
      }

    
    /* Выводим не более $paging_element_count страниц */
    $start_loop_page =  $page - (floor(($paging_element_count/2))); //$page - 5;
    if(($page + (floor(($paging_element_count-1)/2))) > $page_total)//if(($page + 5) > $page_total)
      {
      $start_loop_page = $page_total - $paging_element_count;//$page_total - 10;
      }
    if($start_loop_page < 1)
      {
      $start_loop_page = 1;
      }

    $end_loop_page = $start_loop_page + $paging_element_count;
    if($end_loop_page > $page_total)
      {
      $end_loop_page = $page_total;
      }
      
      
    if($paging_show_number)
      {
      for($pg = $start_loop_page; $pg <= $end_loop_page; $pg++)
        {
        if($pg != $page)
          {
          if($pg == 1)
            {
            $result .= "<li><a href='$url$pg'>$pg</a></li>";
            }
          else
            {
            $result .= "<li><a href='$url$pg'>$pg</a></li>";
            }
          }
        else
          {
          $result .= "<li class='active'><a href='#'>{$pg}</a></li>";
          }
        if($pg < $paging_element_count)
          {
          //$result .= "::";
          }
        }
      }
      
    if($page != $end_loop_page)/* Стрелочка */
      {
      $page_next = $page + 1;
      $result .= "<li><a href='$url$page_next'>$paging_next</a></li>";
      $result .= ($paging_show_last_first) ? "<li><a href='{$url}{$page_total}'>$paging_last</a></li>" : '';
      }
    else
      {
      $result .= "<li class='disabled'><a href='#'>$paging_next</a></li>";
      $result .= ($paging_show_last_first) ? "<li class='disabled'><a href='#'>$paging_last</a></li>" : '';
      }
    }
  $result .= "</ul>";
  $result .= "<div class='clear'></div>";
  $result .= "</div>";

  echo $result;
  }
