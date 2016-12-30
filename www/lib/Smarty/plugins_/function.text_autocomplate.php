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

function smarty_function_text_autocomplate($params, &$smarty)
	{
	extract($params);
	if (empty($size))
		$size = '50';

  if (empty($width))
		$width = '150px';

  if (empty($value))
		$value = '';
  
  if (empty($bgcolor))
		$bgcolor = 'wheat';

echo "<script type=\"text/javascript\" language=\"javascript\" src='/scripts/uncompresed_js/jquery/jquery-ui-1.8.11.custom.min.js'></script>";

  //Скрипт обработчик
  if (empty($file))
    {
		$file = "index.php";
    $default_file=true;
    }

  //Соберем параметры
  ((!$module || !$func) && $default_file) ? $value='Не правельный путь к PHP скрипту!' : $file .= "?module=$module&type=ajax&func=$func";
  
  if($css)
    {
    echo "<link href='/scripts/uncompresed_js/jquery/css/ui-lightness/jquery-ui-1.8.11.custom.css' type='text/css' rel='stylesheet'/>";
    }
    
  echo "<style>
        .ui-menu .ui-menu-item
        {
          clear: left;
          float: left;
          margin: 0;
          padding: 0;
          width: $width;
          background-color: $bgcolor;
          list-style: none;
        }
        .ui-autocomplete-loading { background: white url('/scripts/uncompresed_js/jquery/css/ui-lightness/images/ui-anim_basic_16x16.gif') right center no-repeat; }
        #$name {width:$width;}
        </style>
       ";
  //Мульти строка?(Значения задаются через запятую)
  if($multi)
    {

//    $script = "
//              <script type=\"text/javascript\" language=\"javascript\">
//              $(function() {
//                function split( val ) {
//                  return val.split( /,\s*/ );
//                }
//                function extractLast( term ) {
//                  return split( term ).pop();
//                }
//
//                $( \"#$name\" )
//                  // don't navigate away from the field on tab when selecting an item
//                  .bind( \"keydown\", function( event ) {
//                    if ( event.keyCode === $.ui.keyCode.TAB &&
//                        $( this ).data( \"autocomplete\" ).menu.active ) {
//                      event.preventDefault();
//                    }
//                  })
//                  .autocomplete({
//                    minLength: 0,
//                    source: \"$file\",
//				            focus: function() {
//                      // prevent value inserted on focus
//                      return false;
//                    },
//                    select: function( event, ui ) {
//                      var terms = split( this.value );
//                      // remove the current input
//                      terms.pop();
//                      // add the selected item
//                      terms.push( ui.item.value );
//                      // add placeholder to get the comma-and-space at the end
//                      terms.push( \"\" );
//                      this.value = terms.join( \", \" );
//                      return false;
//                    }
//                  });
//                });
//                </script>
//             ";
    $script = "
                <script type=\"text/javascript\" language=\"javascript\">
                $(function() {
                  function split( val ) {
                    return val.split( /,\s*/ );
                  }
                  function extractLast( term ) {
                    return split( term ).pop();
                  }

                  $( \"#$name\" )
                    // don't navigate away from the field on tab when selecting an item
                    .bind( \"keydown\", function( event ) {
                      if ( event.keyCode === $.ui.keyCode.TAB &&
                          $( this ).data( \"autocomplete\" ).menu.active ) {
                        event.preventDefault();
                      }
                    })
                    .autocomplete({
                      source: function( request, response ) {
                        $.getJSON( \"$file\", {
                          term: extractLast( request.term )
                        }, response );
                      },
                      search: function() {
                        // custom minLength
                        var term = extractLast( this.value );
                        if ( term.length < 2 ) {
                          return false;
                        }
                      },
                      focus: function() {
                        // prevent value inserted on focus
                        return false;
                      },
                      select: function( event, ui ) {
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( \"\" );
                        this.value = terms.join( \", \" );
                        $(\"#$name-id\").val(ui.item.id);
                        return false;
                      }
                    });
                });
                </script>

              ";

    }

  else
    {
    $script = "
              <script type=\"text/javascript\" language=\"javascript\">
              $(function() {
                function log( message ) {
                  $( \"<div/>\" ).text( message ).prependTo( \"#log\" );
                  $( \"#log\" ).attr( \"scrollTop\", 0 );
                }

                $( \"#$name\" ).autocomplete({
                  source: \"$file\",
                  minLength: 2,
                  select: function( event, ui ) {
                    $(\"#$name-id\").val(ui.item.id);
                    log( ui.item ? \"Selected: \" + ui.item.value + \" aka \" + ui.item.id : \"Nothing selected, input was \" + this.value );
                  }
                });
              });
              </script>
              ";
    }

  //Собераем сам INPUT
  $input_view = '';
  $input_view = "<div class='ui-widget'>";
  ($label!='') ? $input_view .= "<label for='$name'>$label: </label>" : $input_view .= '';
  $input_view .= "<input id='$name' name='$name'  size='$size'  value='$value'/>";
  $input_view .= "<input type='hidden' id='$name-id' name='$name-id' value=''>";
  $input_view .= '</div>';

  //Выводим на страницу элемент
  echo $script;
  echo $input_view;

	return $result;
	}

?>