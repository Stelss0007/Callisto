<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_smile($string)
  {
  $icons = array(
            ':)'      => '<img src="/public/images/emoticons/smile.png" alt="smile" class="icon_smile" />',
            ':angel:' => '<img src="/public/images/emoticons/angel.png" alt="smile" class="icon_smile" />',
            ':angry:' => '<img src="/public/images/emoticons/angry.png" alt="smile" class="icon_smile" />',
            '8-)'     => '<img src="/public/images/emoticons/cool.png" alt="smile" class="icon_smile" />',
            ":'("     => '<img src="/public/images/emoticons/cwy.png" alt="smile" class="icon_smile" />',
            ':ermm:'  => '<img src="/public/images/emoticons/ermm.png" alt="smile" class="icon_smile" />',
            ':D'      => '<img src="/public/images/emoticons/grin.png" alt="smile" class="icon_smile" />',
            '<3'      => '<img src="/public/images/emoticons/heart.png" alt="smile" class="icon_smile" />',
            ':('      => '<img src="/public/images/emoticons/sad.png" alt="smile" class="icon_smile" />',
            ':O'      => '<img src="/public/images/emoticons/shocked.png" alt="smile" class="icon_smile" />',
            ':P'      => '<img src="/public/images/emoticons/tongue.png" alt="smile" class="icon_smile" />',
            ';)'      => '<img src="/public/images/emoticons/wink.png" alt="smile" class="icon_smile" />',
      
            ':alien:'   => '<img src="/public/images/emoticons/alien.png" alt="smile" class="icon_smile" />',
            ':blink:'   => '<img src="/public/images/emoticons/blink.png" alt="smile" class="icon_smile" />',
            ':blush:'   => '<img src="/public/images/emoticons/blush.png" alt="smile" class="icon_smile" />',
            ':cheerful:'=> '<img src="/public/images/emoticons/cheerful.png" alt="smile" class="icon_smile" />',
            ':devil:'   => '<img src="/public/images/emoticons/devil.png" alt="smile" class="icon_smile" />',
            ':dizzy:'   => '<img src="/public/images/emoticons/dizzy.png" alt="smile" class="icon_smile" />',
            ':getlost:' => '<img src="/public/images/emoticons/getlost.png" alt="smile" class="icon_smile" />',
            ':happy:'   => '<img src="/public/images/emoticons/happy.png" alt="smile" class="icon_smile" />',
            ':kissing:' => '<img src="/public/images/emoticons/kissing.png" alt="smile" class="icon_smile" />',
            ':ninja:'   => '<img src="/public/images/emoticons/ninja.png" alt="smile" class="icon_smile" />',
            ':pinch:'   => '<img src="/public/images/emoticons/pinch.png" alt="smile" class="icon_smile" />',
            ':pouty:'   => '<img src="/public/images/emoticons/pouty.png" alt="smile" class="icon_smile" />',
            ':sick:'    => '<img src="/public/images/emoticons/sick.png" alt="smile" class="icon_smile" />',
            ':sideways:' => '<img src="/public/images/emoticons/sideways.png" alt="smile" class="icon_smile" />',
            ':silly:'   => '<img src="/public/images/emoticons/silly.png" alt="smile" class="icon_smile" />',
            ':sleeping:'=> '<img src="/public/images/emoticons/sleeping.png" alt="smile" class="icon_smile" />',
            ':unsure:'  => '<img src="/public/images/emoticons/unsure.png" alt="smile" class="icon_smile" />',
            ':woot:'    => '<img src="/public/images/emoticons/w00t.png" alt="smile" class="icon_smile" />',
            ':wassat:'  => '<img src="/public/images/emoticons/wassat.png" alt="smile" class="icon_smile" />'

    );
    return strtr($string, $icons);
  }


?>
