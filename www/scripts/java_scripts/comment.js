var comment_cache_newtpl='';var comment_cache_listtpl='';function comment_create(a,b,c,d){var e=document.getElementById('bbcode_form');if(a=='cancel'){var f=new ajax();var g='';f.requestFile='/index.php';f.method='GET';f.setVar('module','comment');f.setVar('type','ajax');f.setVar('func','list');f.setVar('comm_module',b);f.setVar('comm_key_a',c);f.setVar('comm_key_b',d);f.onCompletion(comment_scrool('mod_comment_list'));f.element='mod_comment_list';f.sendAJAX(g);if(e.user_displayname)e.user_displayname.value='';e.comm_displayname.value='';e.comm_content.value='';return false}if(e.user_displayname&&e.user_displayname.value==''){alert('�� �� ������� ���� ���.');return false}if(e.comm_content.value==''){alert('�� �� �������� ����� �����������.');return false}if(a=='preview'){var f=new ajax();var g='';f.requestFile='/index.php';f.method='POST';f.setVar('module','comment');f.setVar('type','ajax');f.setVar('func','preview');f.setVar('comm_module',b);f.setVar('comm_key_a',c);f.setVar('comm_key_b',d);if(e.user_displayname)f.setVar('user_displayname',f.encodeVAR(e.user_displayname.value));f.setVar('comm_displayname',f.encodeVAR(e.comm_displayname.value));f.setVar('comm_content',f.encodeVAR(e.comm_content.value));f.onShow('��������������� ��������');f.onCompletion(comment_scrool('mod_comment_list'));f.element='mod_comment_list';f.sendAJAX(g);return false}if(a=='create'){var f=new ajax();var g='';f.requestFile='/index.php';f.method='POST';f.setVar('module','comment');f.setVar('type','ajax');f.setVar('func','create');f.setVar('comm_module',b);f.setVar('comm_key_a',c);f.setVar('comm_key_b',d);if(e.user_displayname)f.setVar('user_displayname',f.encodeVAR(e.user_displayname.value));if(e.captcha_string)f.setVar('captcha_string',f.encodeVAR(e.captcha_string.value));f.setVar('comm_displayname',f.encodeVAR(e.comm_displayname.value));f.setVar('comm_content',f.encodeVAR(e.comm_content.value));f.onShow('���������� ������');f.execute=true;f.element='mod_comment_list';f.sendAJAX(g);return false}return false};function comment_modify(a){if(comment_cache_newtpl=='')comment_cache_newtpl=document.getElementById('mod_comment_new').innerHTML;comment_cache_listtpl=document.getElementById('mod_comment_list').innerHTML;var b=new ajax();var c='';b.onShow('�������������� ������');b.setVar('module','comment');b.setVar('type','ajax');b.setVar('func','modify');b.setVar('id',a);b.requestFile='/index.php';b.method='GET';b.onCompletion(comment_scrool('mod_comment_new'));b.execute=true;b.element='mod_comment_new';b.sendAJAX(c);return false}function comment_update(a,b,c,d,e){var f=document.getElementById('bbcode_form');if(a=='cancel'){if(document.getElementById('mod_comment_list').innerHTML!=comment_cache_listtpl)document.getElementById('mod_comment_list').innerHTML=comment_cache_listtpl;comment_scrool('comment_id_'+b);if(comment_cache_newtpl!='')document.getElementById('mod_comment_new').innerHTML=comment_cache_newtpl;return false}if(f.user_displayname&&f.user_displayname.value==''){alert('�� �� ������� ���� ���.');return false}if(f.comm_content.value==''){alert('�� �� �������� ����� �����������.');return false}if(a=='preview'){var g=new ajax();var h='';g.requestFile='/index.php';g.method='POST';g.setVar('module','comment');g.setVar('type','ajax');g.setVar('func','preview');g.setVar('id',b);g.setVar('comm_module',c);g.setVar('comm_key_a',d);g.setVar('comm_key_b',e);if(f.user_displayname)g.setVar('user_displayname',g.encodeVAR(f.user_displayname.value));g.setVar('comm_displayname',g.encodeVAR(f.comm_displayname.value));g.setVar('comm_content',g.encodeVAR(f.comm_content.value));g.onShow('��������������� ��������');g.onCompletion(comment_scrool('mod_comment_list'));g.element='mod_comment_list';g.sendAJAX(h);return false}if(a=='update'){var g=new ajax();var h='';g.requestFile='/index.php';g.method='POST';g.setVar('module','comment');g.setVar('type','ajax');g.setVar('func','update');g.setVar('id',b);g.setVar('comm_module',c);g.setVar('comm_key_a',d);g.setVar('comm_key_b',e);if(f.user_displayname)g.setVar('user_displayname',g.encodeVAR(f.user_displayname.value));g.setVar('comm_displayname',g.encodeVAR(f.comm_displayname.value));g.setVar('comm_content',g.encodeVAR(f.comm_content.value));g.onShow('�������������� ������');g.execute=true;g.element='mod_comment_list';g.sendAJAX(h);if(comment_cache_newtpl!='')document.getElementById('mod_comment_new').innerHTML=comment_cache_newtpl;return false}return false};function comment_delete(a){var b=confirm('�� ������������� ������ ������� �����?');if(b){if(comment_cache_newtpl!='')document.getElementById('mod_comment_new').innerHTML=comment_cache_newtpl;var c=new ajax();var d='';c.setVar('module','comment');c.setVar('type','ajax');c.setVar('func','delete');c.setVar('id',a);c.requestFile='/index.php';c.method='GET';c.element='mod_comment_list';c.onShow('�������� ������');c.sendAJAX(d)}return false}function comment_scrool(a){var b=document.getElementById(a);var c=_get_obj_toppos(b);if(c)scroll(0,c-50)};function comment_captcha_update(){var a=new Date().getTime();document.getElementById('comment_captcha_div').innerHTML='<img src="index.php?module=comment&type=ajax&func=captcha_view&rndval='+a+'" alt="��� ������������" border="0">';return false};