/*
 * Увеличиваем счетчик скачек
*/
function xml_request(q){
  var p;
  try {
    p = new XMLHttpRequest();
  } catch (e) {
    p = new ActiveXObject("Msxml2.XMLHTTP");
  }
  p.open("GET", q, false);
  p.send(null);
	return p.responseText;
}

function doDownload(film_id,file_id)
  {
  str=xml_request("/index.php?module=video&type=ajax&func=film_file_views_inc&film_id="+film_id+"&file_id="+file_id);
  return true;
  }

