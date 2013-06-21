/*
 * Просмотр скринов к фильму
*/
function film_file_screen_show(id)
  {
  var video_ajax = new ajax();
  var varsString = '';

  video_ajax.setVar('module', 'video');
  video_ajax.setVar('type',   'ajax');
  video_ajax.setVar('func',   'film_file_screen_list');
  video_ajax.setVar('id',     id);

 	video_ajax.requestFile = '/index.php';
 	video_ajax.method = 'GET';
 	video_ajax.element = 'mod_video_screen_list_'+id;
 	video_ajax.sendAJAX(varsString);
 	return false;
  }

/*
 * Прятанье скриншотов
*/
function film_file_screen_hide(id)
  {
	document.getElementById('mod_video_screen_list_'+id).innerHTML = '<a href="#" onclick="film_file_screen_show(\''+id+'\'); return false;" title="Показать"><b>Скриншоты »</b></a>';
 	return false;
  }

/*
 * Просмотр раскодровок к фильму
*/
function film_file_rask_show(id)
  {
  var video_ajax = new ajax();
  var varsString = '';

  video_ajax.setVar('module', 'video');
  video_ajax.setVar('type',   'ajax');
  video_ajax.setVar('func',   'film_file_rask_list');
  video_ajax.setVar('id',     id);

 	video_ajax.requestFile = '/index.php';
 	video_ajax.method = 'GET';
 	video_ajax.element = 'mod_video_rask_list_'+id;
 	video_ajax.sendAJAX(varsString);
 	return false;
  }

/*
 * Прятанье раскодровок
*/
function film_file_rask_hide(id)
  {
	document.getElementById('mod_video_rask_list_'+id).innerHTML = '<a href="#" onclick="film_file_rask_show(\''+id+'\'); return false;" title="Показать"><b>Раскадровка »</b></a>';
 	return false;
  }
