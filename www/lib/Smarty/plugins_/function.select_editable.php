<?php

/*
 * Smarty plugin
 *
 * $size      - ������ (50)
 * $width     - ������ (150px)
 * $value     - �������� � ��������� ���� ''
 * $bgcolor   - ���� ���� ����������� ������ 'wheate'
 * $file      - ���� ���������� 'index.php'
 * $module    - ��� ������. ���� ���� ���������� �� ��������, �� ������� ��������
 * $func      - ��� �������. ���� ���� ���������� �� ��������, �� ������� ��������
 * $css       - ��������� css UI 
 */

function smarty_function_select_editable($params, &$smarty)
	{
	extract($params);
	if (empty($size))
		$size = '4';

  if (empty($width))
		$width = '150px';
 
 
 $script = "
           <script type=\"text/javascript\" language=\"javascript\">
              //List box by Rus
              function ListShow(id)
                {
                var eICP=$('#'+id).position();
                $('#$name"."_div').css({
                  'top':eICP.top+(jQuery('#'+id).outerHeight())-0+'px',
                  'left':(eICP.left)+'px',
                  'position':'absolute',
                  'text-indent':'0px'
                });
                $('#$name"."Lst').width($('#$name').width()+$('#$name"."Btn').width());
                //.fadeIn('fast');
                $('#$name"."_div').toggle();
                }

              function ListSelected(id,val)
                {
                $('#'+id).val(val);
                $('#$name"."_div').hide();
                $('#$name"."_div').fadeOut();
                $onChange
                $(this);
                }

                // ���� ������ ������ ���� ���-������ �� �������� ��� �������� ��������,
                // �� ����� �������:
                $(document).click(function(event){
                  var target = $(event.target);
                  if (!target.attr('id').match(/^$name/) && target.parents('#$name"."_div').length == 0)
                    $('#$name"."_div').hide();
                });
              </script>
              ";

 $options='';
 foreach ($items as $item)
   {
   if($item==$value)
     {
     $options .= "<option value='$item' selected='selected'>$item</option>";
     }
   else
     {
     $options .= "<option value='$item'>$item</option>";
     }
   }


 $html = "<input name='$name' id='$name' value='$value' size=4 style='width:$width;' />
          <input type='button' value='&#8711;' onClick=\"ListShow('$name');\" id='$name"."Btn' style='width:25px; margin-left:-10px;'>
          <div id='$name"."_div' style='display:none;'>
            <select onchange=\"ListSelected('$name',this.value);\" id='$name"."Lst'  size='$size' style='width:$width;'>
              $options
            </select>
          </div>
          ";

  //������� �� �������� �������
  echo $script;
  echo $html;
 // TODO: �������� �������� ���������� ��� ������������ <option>.

	return $result;
	}

?>