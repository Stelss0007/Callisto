/*
 * Админские штучки
 */


/*
 * Подтверждение удаления
 * Для отлавливания перехода по ссылке удаления
 * нужно к ссылке повесить класс class='delete' и выводимое название элемента например: title="{$quote.quote_name}"
 *
 */
///////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){
  $("a.delete").click(function () {
    return confirm('Вы действительно хотите удалить элемнт \"'+$(this).attr('title')+'\"?');
  });

//..........................................................................................
  $(".outer tr").mouseover(function() {
    $(this).addClass("over");
  });

//..........................................................................................
  $(".outer tr").mouseout(function() {
    $(this).removeClass("over");
  });

//..........................................................................................
  $(".formButton").click(function () {
    if(($('.isValid').val()=='') || ($('.isValid').val()==0)){
      $('.isValid').css("background","red");
      alert('Не заполнено имя');
      return false;
    }
  });
//..........................................................................................
 $('#rusListBtn').blur(function(){
  rusListSelected('rusListInput',document.getElementById('rusListLst').value);
  $("#rusList").hide();
  $("#rusList").fadeOut();
  return true;
  });

//..........................................................................................
  $(".isValid").click(function () {
    $('.isValid').css("background","white");
  });
});

////////////////////////////////////////////////////////////////////////////////////////////


function cloneHTMLElement(myclass, element_name)
  {
  var num     = $('.'+myclass).length; // Сколько всего елементов в класе
  var newNum  = new Number(num + 1);      // Новый индекс для элемента

  //Создадим клон елемента
  //var newElem = $('#'+myclass + num).clone().attr('id', myclass + newNum);
  var newElem = $('#'+myclass + 1).clone().attr('id', myclass + newNum);

  //Манипуляции с свойствами созданого элемента
  newElem.children(':first').attr('id', element_name + newNum).attr('name', element_name+'[]');

  //Вставим элемент после родительского
  $('#'+myclass + num).after(newElem);
  $('#'+myclass + newNum).append("<a href='#' onclick=\"deleteHTMLElement('"+myclass+"', '"+newNum+"'); return false;\">Удалить</a>");

  // Енеблим кнопку del
  $('#btnDel').attr('disabled','');

  // Добавлять только 5 элементов
  if (newNum == 5)
  $('#btnAdd').attr('disabled','disabled');
  }

function deleteHTMLElement(myclass, num)
  {
  //var num = $('.'+myclass).length;            // Сколько клонированых елементов в диве
  $('#'+myclass + num).remove();         // Удалим последний элемент

  // enable the "add" button
  $('#btnAdd').attr('disabled','');

  // Если только один элемент дисеблим кнопку del
  if (num-1 == 1)
  $('#btnDel').attr('disabled','disabled');
  }

////////////////////////ЦИТАТЫ//////////////////////////////////////////////////

//Вывод выбраной картинки
<!-- Begin
/*Предпросмотр для upload картинок*/
/***** Дефолтные переменные *****/
// Ширина
var maxWidth=500;
//Высота
var maxHeight=500;
// Розрешенные типы
var fileTypes=["bmp","gif","png","jpg","jpeg"];
// Управляемая картинка
var outImage="previewField";
// Деф картинка
var defaultPic="spacer.gif";
//Темп картинка
var tempPic="";
/**********/
function imgPreview(what){
  var source=what.value;
  var ext=source.substring(source.lastIndexOf(".")+1,source.length).toLowerCase();
  for (var i=0; i<fileTypes.length; i++){
    if (fileTypes[i]==ext){
      break;
    }
  }
  globalPic=new Image();
  if (i<fileTypes.length){

    //Для firefox
    try{
      globalPic.src=what.files[0].getAsDataURL();
    }catch(err){
      globalPic.src=source;
    }
  }else {
    globalPic.src=defaultPic;
    alert("Не верный тип файла"+fileTypes.join(", "));
  }
  setTimeout("imgApplyChanges()",200);
}

var globalPic;
function imgApplyChanges(){
  var field=document.getElementById(outImage);
  var x=parseInt(100);
  var y=parseInt(300);
  if (x>maxWidth){
    y*=maxWidth/x;
    x=maxWidth;
  }
  if (y>maxHeight) {
    x*=maxHeight/y;
    y=maxHeight;
  }
  if (tempPic == '')
  {
    tempPic=field.src;
    $('#imgReset').css('display', 'inline');
  }

  //field.style.display=(x<1 || y<1)?"none":"";
  field.src=globalPic.src;
  field.width=x;
//field.height=y;
}

//Обнулим картинку(вернем назад)
function imgPreviewReset(){
  var field=document.getElementById(outImage);
  field.src=tempPic;
  tempPic='';
  document.getElementById('userfile').value='';
  $('#imgReset').css('display', 'none');
}

// End -->

