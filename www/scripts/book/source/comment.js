var comment_cache_newtpl        = '';
var comment_cache_listtpl       = '';

/*
 * ���������� ������
*/
function comment_create(action, comm_module, comm_key_a, comm_key_b)
  {
	var form = document.getElementById('bbcode_form');

	//�������� - "������"
  if (action=='cancel')
    {
    //��������� ������ ���������
    var comment_ajax = new ajax();
    var varsString = '';
    comment_ajax.requestFile = '/index.php';
    comment_ajax.method = 'GET';
    comment_ajax.setVar('module', 'comment');
    comment_ajax.setVar('type',   'ajax');
    comment_ajax.setVar('func',   'list');
    comment_ajax.setVar('comm_module', comm_module);
    comment_ajax.setVar('comm_key_a',  comm_key_a);
    comment_ajax.setVar('comm_key_b',  comm_key_b);
	 	//comment_ajax.onShow ('������');
   	comment_ajax.onCompletion (comment_scrool('mod_comment_list'));
		comment_ajax.element = 'mod_comment_list';
		comment_ajax.sendAJAX(varsString);

    //������� ���������� � �����
    if (form.user_displayname)
      form.user_displayname.value='';
    form.comm_displayname.value='';
    form.comm_content.value='';

		return false;
    }

	//��������
	if (form.user_displayname && form.user_displayname.value == '')
  	{
		alert ('�� �� ������� ���� ���.');
		return false;
    }

	if (form.comm_content.value == '')
  	{
		alert ('�� �� �������� ����� �����������.');
		return false;
  	}


	//�������������
  if (action=='preview')
    {
		//������������ � ������ ������������
    //comment_scrool('mod_comment_list');

    var comment_ajax = new ajax();
    var varsString = '';
  	comment_ajax.requestFile = '/index.php';
  	comment_ajax.method = 'POST';
    comment_ajax.setVar('module', 'comment');
    comment_ajax.setVar('type',   'ajax');
	  comment_ajax.setVar('func',   'preview');
    comment_ajax.setVar('comm_module', comm_module);
    comment_ajax.setVar('comm_key_a',  comm_key_a);
    comment_ajax.setVar('comm_key_b',  comm_key_b);
    if (form.user_displayname)
  	  comment_ajax.setVar('user_displayname',  comment_ajax.encodeVAR(form.user_displayname.value));
    comment_ajax.setVar('comm_displayname',  comment_ajax.encodeVAR(form.comm_displayname.value));
    comment_ajax.setVar('comm_content',  		 comment_ajax.encodeVAR(form.comm_content.value));

   	comment_ajax.onShow ('��������������� ��������');
   	comment_ajax.onCompletion (comment_scrool('mod_comment_list'));
		comment_ajax.element = 'mod_comment_list';
		comment_ajax.sendAJAX(varsString);

		return false;
    }

  //����������
  if (action=='create')
    {
		//������������ � ������ ������������
    var comment_ajax = new ajax();
    var varsString = '';

  	comment_ajax.requestFile = '/index.php';
  	comment_ajax.method = 'POST';
    comment_ajax.setVar('module', 'comment');
    comment_ajax.setVar('type',   'ajax');
	  comment_ajax.setVar('func',   'create');
    comment_ajax.setVar('comm_module', comm_module);
    comment_ajax.setVar('comm_key_a',  comm_key_a);
    comment_ajax.setVar('comm_key_b',  comm_key_b);
    if (form.user_displayname)
  	  comment_ajax.setVar('user_displayname',  comment_ajax.encodeVAR(form.user_displayname.value));
    if (form.captcha_string)
  	  comment_ajax.setVar('captcha_string',  comment_ajax.encodeVAR(form.captcha_string.value));
    comment_ajax.setVar('comm_displayname',  comment_ajax.encodeVAR(form.comm_displayname.value));
    comment_ajax.setVar('comm_content',  		 comment_ajax.encodeVAR(form.comm_content.value));
   	comment_ajax.onShow ('���������� ������');
   	comment_ajax.execute = true;
		comment_ajax.element = 'mod_comment_list';
		comment_ajax.sendAJAX(varsString);

		return false;
    }

	return false;
	};

/*
 * �������������� ������
*/
function comment_modify(id)
  {
  //���������� �������� ������������ �����
  if (comment_cache_newtpl=='')
		comment_cache_newtpl = document.getElementById('mod_comment_new').innerHTML;
  comment_cache_listtpl = document.getElementById('mod_comment_list').innerHTML;

  var comment_ajax = new ajax();
  var varsString = '';
 	comment_ajax.onShow ('�������������� ������');

  comment_ajax.setVar('module', 'comment');
  comment_ajax.setVar('type',   'ajax');
  comment_ajax.setVar('func',   'modify');
  comment_ajax.setVar('id',     id);

 	comment_ajax.requestFile = '/index.php';
 	comment_ajax.method = 'GET';
 	comment_ajax.onCompletion (comment_scrool('mod_comment_new'));
 	comment_ajax.execute = true;
 	comment_ajax.element = 'mod_comment_new';
 	comment_ajax.sendAJAX(varsString);
 	return false;
  }

/*
 * �������������� ������
*/
function comment_update(action, id, comm_module, comm_key_a, comm_key_b)
  {
	var form = document.getElementById('bbcode_form');

	//�������� - "������"
  if (action=='cancel')
    {
    //�������������� ������ ���������
    if (document.getElementById('mod_comment_list').innerHTML != comment_cache_listtpl)
      document.getElementById('mod_comment_list').innerHTML = comment_cache_listtpl;

    //������� � �������������� ��������
    comment_scrool('comment_id_'+id);

    //�������������� ����� ����������
    if (comment_cache_newtpl!='')
      document.getElementById('mod_comment_new').innerHTML = comment_cache_newtpl;

		return false;
    }

	//��������
	if (form.user_displayname && form.user_displayname.value == '')
  	{
		alert ('�� �� ������� ���� ���.');
		return false;
    }

	if (form.comm_content.value == '')
  	{
		alert ('�� �� �������� ����� �����������.');
		return false;
  	}


	//�������������
  if (action=='preview')
    {
		//������������ � ������ ������������
    //comment_scrool('mod_comment_list');

    var comment_ajax = new ajax();
    var varsString = '';
  	comment_ajax.requestFile = '/index.php';
  	comment_ajax.method = 'POST';
    comment_ajax.setVar('module', 'comment');
    comment_ajax.setVar('type',   'ajax');
	  comment_ajax.setVar('func',   'preview');
    comment_ajax.setVar('id', id);
    comment_ajax.setVar('comm_module', comm_module);
    comment_ajax.setVar('comm_key_a',  comm_key_a);
    comment_ajax.setVar('comm_key_b',  comm_key_b);
    if (form.user_displayname)
  	  comment_ajax.setVar('user_displayname',  comment_ajax.encodeVAR(form.user_displayname.value));
    comment_ajax.setVar('comm_displayname',  comment_ajax.encodeVAR(form.comm_displayname.value));
    comment_ajax.setVar('comm_content',  		 comment_ajax.encodeVAR(form.comm_content.value));

   	comment_ajax.onShow ('��������������� ��������');
   	comment_ajax.onCompletion (comment_scrool('mod_comment_list'));
		comment_ajax.element = 'mod_comment_list';
		comment_ajax.sendAJAX(varsString);

		return false;
    }

  //����������
  if (action=='update')
    {
    var comment_ajax = new ajax();
    var varsString = '';
  	comment_ajax.requestFile = '/index.php';
  	comment_ajax.method = 'POST';
    comment_ajax.setVar('module', 'comment');
    comment_ajax.setVar('type',   'ajax');
	  comment_ajax.setVar('func',   'update');
    comment_ajax.setVar('id',				 	 id);
    comment_ajax.setVar('comm_module', comm_module);
    comment_ajax.setVar('comm_key_a',  comm_key_a);
    comment_ajax.setVar('comm_key_b',  comm_key_b);
    if (form.user_displayname)
  	  comment_ajax.setVar('user_displayname',  comment_ajax.encodeVAR(form.user_displayname.value));
    comment_ajax.setVar('comm_displayname',  comment_ajax.encodeVAR(form.comm_displayname.value));
    comment_ajax.setVar('comm_content',  		 comment_ajax.encodeVAR(form.comm_content.value));
   	comment_ajax.onShow ('�������������� ������');
   	comment_ajax.execute = true;
		comment_ajax.element = 'mod_comment_list';
		comment_ajax.sendAJAX(varsString);

    //�������������� ����� ����������
    if (comment_cache_newtpl!='')
      document.getElementById('mod_comment_new').innerHTML = comment_cache_newtpl;

		return false;
    }

	return false;
	};

/*
 * �������� ������
*/
function comment_delete(id)
  {
  var agree=confirm('�� ������������� ������ ������� �����?');

  if (agree)
  	{
  	//�� ������ ������ �������������� ����� ��� ����������
	  if (comment_cache_newtpl!='')
			document.getElementById('mod_comment_new').innerHTML = comment_cache_newtpl;

		//���������� ��������
	  var comment_ajax = new ajax();
    var varsString = '';

    comment_ajax.setVar('module', 'comment');
    comment_ajax.setVar('type',   'ajax');
    comment_ajax.setVar('func',   'delete');
    comment_ajax.setVar('id',     id);

  	comment_ajax.requestFile = '/index.php';
  	comment_ajax.method = 'GET';
  	comment_ajax.element = 'mod_comment_list';
  	comment_ajax.onShow ('�������� ������');

  	comment_ajax.sendAJAX(varsString);
  	}

  return false;
  }

/*
 * ��������� ������ � ������� ��������
*/
function comment_scrool(scrool_element)
  {
	var comment_main_obj = document.getElementById( scrool_element );
	var comment_pos_top  = _get_obj_toppos( comment_main_obj );
	if ( comment_pos_top ) scroll( 0, comment_pos_top - 50 );
  };

/*
 * ���������� ���� �����
*/
function comment_captcha_update()
  {
	var rndval = new Date().getTime();
	document.getElementById('comment_captcha_div').innerHTML = '<img src="index.php?module=comment&type=ajax&func=captcha_view&rndval=' + rndval + '" alt="��� ������������" border="0">';
	return false;
  };