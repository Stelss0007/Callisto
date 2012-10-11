<?php
/*
 * Smarty plugin
 */
function smarty_function_quote_add($params, &$smarty)
	{
  sysJSLoad('jsAeroWindow', array("jsAeroWindow"),FALSE, FALSE, TRUE);
  sysJSLoad('quote', array("quote"), FALSE, FALSE, FALSE);
  
  // Проверка наличия модуля
  if (!sysModAvailable ('quote')) return '';

	$mod_param = array('quote_module'     =>  $params['modname'],
	                   'quote_key_a'      =>  $params['quote_key_a'],
	                   'quote_key_b'      =>  $params['quote_key_b']
	                  );
	
  $result="<a href='".sysModURL('my','user','quote_new',$mod_param)."'>Цитировать</a>";

  if($params['java']==1&&$params['ajax']==0)
  {
    $result.="<form action=''>
              <input type='checkbox' name='hot_quote' id='hot_quote' value='1' checked>Быстрые цитаты
             </form>

            <div id='WindowQuote' style='display: none;'>
                <form method='post' action='/index.php?module=quote&amp;type=admin&amp;func=create' name='item_new_form'>
                    <input type='hidden' value='$params[modname]' name='quote_module'>
                    <input type='hidden' value='$params[quote_key_a]' name='quote_key_a'>
                    <input type='hidden' value='$params[quote_key_b]' name='quote_key_b'>
                    <input type='hidden' value='$params[quote_auth_user_id]' name='quote_auth_user_id'>

                    <input type='hidden' value='$params[quote_name]' name='quote_name'>
                    <input type='hidden' value='$params[quote_auth_name]' name='quote_auth_name'>
                    <input type='hidden' value='$params[quote_auth_url]' name='quote_auth_url'>
                    <input type='hidden' name='quote_content' id='quote_content'>
                    <div id='quoteDiv' style='height:250px;overflow-y: scroll;'></div>

                    <br><hr>
                    <input type='submit' value='Добавить цитату'>
               </form>

            </div>

  ";
  }

  if($params['ajax']==1||empty($params['ajax']))
  {
     $result.="<form action=''>
                <input type='checkbox' name='hot_quote' id='hot_quote' value='1' checked>Быстрые цитаты
               </form>

              <div id='WindowQuote' style='display: none;'>
                    <form action='/index.php?module=quote&type=ajax&func=saveToWord' method='post' target='mainFrame' id='item_new_form' name='item_new_form'>
                        <input type='hidden' value='$params[modname]' name='quote_module' id='quote_module'>
                        <input type='hidden' value='$params[quote_key_a]' name='quote_key_a' id='quote_key_a'>
                        <input type='hidden' value='$params[quote_key_b]' name='quote_key_b' id='quote_key_b'>
                        <input type='hidden' value='$params[quote_auth_user_id]' name='quote_auth_user_id' id='quote_auth_user_id'>

                        <input type='hidden' value='$params[quote_name]' name='quote_name' id='quote_name'>
                        <input type='hidden' value='$params[quote_auth_name]' name='quote_auth_name' id='quote_auth_name'>
                        <input type='hidden' value='$params[quote_auth_url]' name='quote_auth_url' id='quote_auth_url'>
                        <input type='hidden' name='quote_content' id='quote_content'>

                        <div id='quoteconteiner'>
                        <div id='quoteDiv' style='height:250px;overflow-y: scroll; margin-left: 10px;'></div>
                        <iframe name='mainFrame' height='0' width='0' src=''></iframe>
                        <br><hr>

                       
                       <a href='' title='Добавить в цитатник' class='button win' id='sendQuote' onClick='sendMyQuote();return false;'>Добавить в цитатник</a><a href='google.ru' title='Сохранить цитату на диск' class='button win' onClick=\"$('#item_new_form').submit();return false;\">Сохранить цитату</a>
                        
                        
                       </div>
                   </form>
                </div>";
  }
 
  return  $result;//$modresult['content'];
  }

?>


