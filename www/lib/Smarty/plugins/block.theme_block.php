<?php
/*
 * Smarty plugin
 * $name
 * $text
 * $width, $height
 * Generete block temlate if admin add additionl info for administration block
 */
function smarty_block_theme_block($params, $content, $smarty, &$repeat)
    {
    
  // only output on the closing tag
    if(!$repeat)
        {  
        extract ($params);

        $userInfo = $smarty->getTemplateVars('currentUserInfo');

        if(!$userInfo['isAdmin'])
          {
          return $content;
          }
        $contentAdmin = '<div class="block-item-admin-panel" data-position="'.$block['position'].'" data-weight="'.$block['weight'].'" data-id="'.$block['id'].'">'
                .'<div class="block-toolbar">'
                  .'<a href="/admin/blocks/modify/'.$block['id'].'" class="block-edit" data-id="'.$block['id'].'"><span class="icon-cog"></span></a>'
                  .'<a href="/admin/blocks/delete/'.$block['id'].'" class="block-delete" data-id="'.$block['id'].'"><span class="icon-trash"></span></a>'
                .'</div>'
               .$content
               .'</div>'
               ;
        return $contentAdmin;
        }
    }

