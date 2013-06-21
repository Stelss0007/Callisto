var search_cache_results        = new Array();
var search_prev_string          = '';

/*
 * ������ �������, �������� ���������
*/
function search_onkeydown(event)
  {
  var LiveText = document.getElementById('mod_search_list');

  if (navigator.userAgent.indexOf("Safari") > 0 || navigator.product == "Gecko")
    {isIE = false;}
     else {isIE = true;}

  //������������ ������� ������ "������� �����", "������� ������", "enter"
  if (event.keyCode == 37 || event.keyCode == 39)
    {//���� �� ������
    return true;
    }

  //������������ ������� ������ "escape"
  if (event.keyCode == 27)
    {
    //�������� ���������� ������
    search_hide();
    return true;
    }

  //������������ ������� ������ "enter"
  if (event.keyCode == 13)
    {
    highlight = document.getElementById("LiveTextHighlight");
    if (highlight)
    	{
	    search_clicked(highlight);
	    //�������� ���������� ������
	    }
    search_hide();
    return true;
    }

  //������������ ������� ������� "������� ����"
  if (event.keyCode == 40 )
    {
    highlight = document.getElementById("LiveTextHighlight");
    //���� �������� ������� �� �������
    if (!highlight)
      {
      var tbody = LiveText.getElementsByTagName("TBODY").item(0);
      highlight = tbody.firstChild;
      }
      else
        {
        highlight.removeAttribute("id");
        highlight = highlight.nextSibling;
        }

    if (highlight)
      {
      highlight.setAttribute("id","LiveTextHighlight");
      value = highlight.getAttribute("_value");
      //LTSetSelectedValue(LiveTextId, value);
      }

    if (!isIE) { event.preventDefault(); }
    return true;
    }

  //������������ ������� ������� "������� �����"
  if (event.keyCode == 38 )
    {
    highlight = document.getElementById("LiveTextHighlight");
    //���� �������� ������� �� �������
    if (!highlight)
      {
      var tbody = LiveText.getElementsByTagName("TBODY").item(0);
      highlight = tbody.lastChild;
      }
      else
        {
        highlight.removeAttribute("id");
        highlight = highlight.previousSibling;
        }

    if (highlight)
      {
      highlight.setAttribute("id","LiveTextHighlight");
      value = highlight.getAttribute("_value");
      //LTSetSelectedValue(LiveTextId, value);
      }

    if (!isIE) { event.preventDefault(); }
    return true;
    }

  return true;
  }

/*
 * ��������� �������, ���������� �����
*/
function search_onkeyup(event)
  {
  var LiveText = document.getElementById('mod_search_list');
  var search_string = document.getElementById('mod_search_string').value;

	//��������
  if (event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 27 || event.keyCode == 13 || event.keyCode == 40 || event.keyCode == 38)
    {//���� �� ������
    return true;
    }

  if (search_string.length<2)
    {
    search_hide();
    return true;
    }

	//���� ���� ������
  if (search_prev_string==search_string)
  	{
  	search_show();
  	return true;
  	}

  //�������� � ����
  if (search_cache_results[ search_string ]!=undefined && search_cache_results[ search_string ]!='')
    {
    document.getElementById('mod_search_list').innerHTML = search_cache_results[ search_string ];
    search_show();
  	return true;
    }


  //���������� �����
  search_prev_string = search_string;
  var search_ajax = new ajax();
  var varsString = '';

 	search_ajax.execute = true;
  search_ajax.requestFile = '/index.php';
  search_ajax.method = 'GET';
  search_ajax.setVar('module', 'search');
  search_ajax.setVar('type',   'ajax');
  search_ajax.setVar('func',   'view');
  search_ajax.setVar('search_string', search_ajax.encodeVAR(search_string));

	search_ajax.element = 'mod_search_list';
	search_ajax.sendAJAX(varsString);

	return true;
  }

/*
 * ���������� ���������� ������
*/
function search_show()
  {
  //���������� ������ ���� �������� ������ �� ������
  if (document.getElementById('mod_search_list').innerHTML=='') return true;
  document.getElementById('mod_search_list').style.display = 'block';
  return true;
  }

/*
 * �������� ���������� ������
*/
function search_hide()
  {
  document.getElementById('mod_search_list').style.display = 'none';

  document.getElementById('mod_search_list').innerHTML='';

  return true;
  }

/**
 * ���� �� ������ � ���������� ������
 */
function search_clicked(el)
  {
  highlight = document.getElementById("LiveTextHighlight");
  if (highlight)  highlight.removeAttribute("id");

	//�������� ����� ��������� �������������
  var value = el.getAttribute('_value');
 	search_selected(value);
	search_hide();

  return true;
  }

/**
 * ������������ ������ � ����������� ������
 */
function search_hover(el)
  {
  highlight = document.getElementById("LiveTextHighlight");
  if (highlight) highlight.removeAttribute("id");

  el.setAttribute("id","LiveTextHighlight");
	return true;
  }

/**
 * ������ ����� ��������� ������������� �� ��������� ������ ��� �� �����
 */
function search_selected(value)
  {
	document.getElementById('mod_search_string').value=value;
	return true;
  }

/*
 * �������� � �������� ��������� ������
*/
function search_cache_set(search_string)
  {
  if (document.getElementById('mod_search_list').innerHTML!='' && search_string!='')
    search_cache_results[ search_string ] = document.getElementById('mod_search_list').innerHTML;
  return true;
  }