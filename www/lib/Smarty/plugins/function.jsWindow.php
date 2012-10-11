<?php

/*
 * Smarty plugin
 *
 * $size      - размер (50)
 * $width     - ширина (150px)
 * $value     - значение в текстовом поле ''
 * $bgcolor   - цвет фона выпадающего списка 'wheate'
 * $file      - файл обработчик 'index.php'
 * $module    - имя модуля. Если файл обработчик по дефоулту, то наличие критично
 * $func      - имя функции. Если файл обработчик по дефоулту, то наличие критично
 * $css       - подлючить css UI 
 */

function smarty_function_jsWindow($params, &$smarty)
	{
	extract($params);
	
  if (empty($width))
		$width = '150px';
 
  sysJSLoad('jsWindow', array("jsWindow"),FALSE, FALSE, TRUE);
 
 $script = "
           <script type=\"text/javascript\" language=\"javascript\">

             function jsNewWindow()
              {
              var w = $(window);

              var y = w.scrollTop();
              var x = w.width()+w.scrollLeft();
               z=50
              alert(x + ' '+y);

              $.newWindow({
                  id: 'iframewindow',
                  title: 'Rus123',
                  width: 200,
                  height: 200,
                  posx: 20,
                  posy: y,
                  content: 'hi-hi',
                  onDragBegin : null,
                  onDragEnd : null,
                  onResizeBegin : null,
                  onResizeEnd : null,
                  onAjaxContentLoaded : null,
                  statusBar: true,
                  minimizeButton: true,
                  maximizeButton: true,
                  closeButton: true,
                  draggable: true,
                  resizeable: true
                });
              }
            
              $.updateWindowContent('iframewindow',\"<iframe src='http://www.wikipedia.com' width='600' height='400' />\");
             
           </script>
           ";

 $html = "
          <a id='createwindow' href='javascript:jsNewWindow();'>Create a new window</a>
         ";

  //Выводим на страницу элемент
  echo $script;
  echo $html;
 

	return $result;
	}

?>