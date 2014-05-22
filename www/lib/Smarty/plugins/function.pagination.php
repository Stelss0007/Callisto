<?php

/*
 * Smarty plugin
 *
 * $show_paging_text  - флаг описания постранички (1), например "Страница (1/10):"
 *

  {jsGalery name='rus4' show=true autoplay='false'  transition='0' height=330 speed=3000}
 */

function smarty_function_pagination($params, &$smarty)
  {
  extract($params);
  extract($smarty->get_template_vars('pagination'));
  
  //Default values
  if(!isset($show_paging_text)) $show_paging_text = 1;
  if(!isset($paging_text)) $paging_text = "Страницы: (%%page%%/%%page_total%%)";
  

  $url = appCurPageURL();
  $url = appUpdateUrlQuery($url, array('page' => ''));

  //print_r($smarty->get_template_vars('pagination'));
  $page_count = 11;
  if($page_count > $page_total)
    {
    $page_count = $page_total;
    }


  $result = '<div class="pagination">';
  
  if($show_paging_text) 
    {
    //$result .= "<div class='pagination-info'><b>Страницы: ({$page}/{$page_total}) </b></div>";
    $result .= "<div class='pagination-info'><b>".  appStrReplaceTemplate($paging_text, $smarty->get_template_vars('pagination'))." </b></div>";
    }
    
  $result .= "<ul class='pagination-items'>";

  if($page_total > 1)
    {
    $page_prev = $page - 1;
    if($page_prev == 0) //на первую страницу номер не включаем
      {
      $result .= "<li class='disabled'><a href='#'>«</a></li>";
      }
    else
      {
      $result .= "<li><a href='$url$page_prev'>«</a></li>";
      }




    /* Выводим не более 11 страниц */
    $start_loop_page = $page - 5;
    if(($page + 5) > $page_total)
      {
      $start_loop_page = $page_total - 10;
      }
    if($start_loop_page < 1)
      {
      $start_loop_page = 1;
      }

    $end_loop_page = $start_loop_page + $page_count;
    if($end_loop_page > $page_total)
      {
      $end_loop_page = $page_total;
      }

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
      if($pg < $page_count)
        {
        //$result .= "::";
        }
      }
    if($page != $end_loop_page)/* Стрелочка */
      {
      $page_next = $page + 1;
      $result .= "<li><a href='$url$page_next'>»</a></li>";
      }
    else
      {
      $result .= "<li class='disabled'><a href='#'>»</a></li>";
      }
    }
  $result .= "</ul>";
  $result .= "<div class='clear'></div>";
  $result .= "</div>";

  echo $result;
  }
