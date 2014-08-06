<?php
/*
 * Smarty plugin
 * $name
 * $text
 * $width, $height
 * Generete block temlate if admin add additionl info for administration block
 */
function smarty_block_theme_block($params, $content,  &$smarty)
  {
  extract ($params);
  
  //if (empty ($name)) $name='bbcode_field_'.$bbeditor_num;
   
  //Сделаем обертку блоку, если это админ знач добавим блок оберку
  $userInfo = $smarty->get_template_vars('currentUserInfo');
  
  if(!$userInfo['isAdmin'])
    {
    return $content;
    }
  return '<div class="block-item-admin-panel" data-position="'.$block['block_position'].'" data-weight="'.$block['block_weight'].'" data-id="'.$block['id'].'">'
          .'<div class="block-toolbar">'
            .'<a href="/admin/blocks/modify/'.$block['id'].'" class="block-edit" data-id="'.$block['id'].'"><span class="icon-cog"></span></a>'
            .'<a href="#" class="block-delete" data-id="'.$block['id'].'"><span class="icon-trash"></span></a>'
          .'</div>'
         .$content
         .'</div>'
         ;
  }

?>