/*
 * —мена мес€ца
*/
function doCalendar(month, year)
  {
  var calendar_ajax = new ajax();
  var varsString = '';
  calendar_ajax.setVar('module', 'calendar');
  calendar_ajax.setVar('type',   'ajax');
  calendar_ajax.setVar('func',   'view');
  calendar_ajax.setVar('year', year);
  calendar_ajax.setVar('month', month);

  calendar_ajax.requestFile = '/index.php';
  calendar_ajax.method = 'GET';
  calendar_ajax.element = 'calendar-layer';
  calendar_ajax.sendAJAX(varsString);
  };