/*
 * ��������� ������
 */


/*
 * ������������� ��������
 * ��� ������������ �������� �� ������ ��������
 * ����� � ������ �������� ����� class='delete' � ��������� �������� �������� ��������: title="{$quote.quote_name}"
 *
 */
///////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){
  $("a.delete").click(function () {
    return confirm('�� ������������� ������ ������� ������ \"'+$(this).attr('title')+'\"?');
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
      alert('�� ��������� ���');
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
  var num     = $('.'+myclass).length; // ������� ����� ��������� � �����
  var newNum  = new Number(num + 1);      // ����� ������ ��� ��������

  //�������� ���� ��������
  //var newElem = $('#'+myclass + num).clone().attr('id', myclass + newNum);
  var newElem = $('#'+myclass + 1).clone().attr('id', myclass + newNum);

  //����������� � ���������� ��������� ��������
  newElem.children(':first').attr('id', element_name + newNum).attr('name', element_name+'[]');

  //������� ������� ����� �������������
  $('#'+myclass + num).after(newElem);
  $('#'+myclass + newNum).append("<a href='#' onclick=\"deleteHTMLElement('"+myclass+"', '"+newNum+"'); return false;\">�������</a>");

  // ������� ������ del
  $('#btnDel').attr('disabled','');

  // ��������� ������ 5 ���������
  if (newNum == 5)
  $('#btnAdd').attr('disabled','disabled');
  }

function deleteHTMLElement(myclass, num)
  {
  //var num = $('.'+myclass).length;            // ������� ������������ ��������� � ����
  $('#'+myclass + num).remove();         // ������ ��������� �������

  // enable the "add" button
  $('#btnAdd').attr('disabled','');

  // ���� ������ ���� ������� �������� ������ del
  if (num-1 == 1)
  $('#btnDel').attr('disabled','disabled');
  }

////////////////////////������//////////////////////////////////////////////////

//����� �������� ��������
<!-- Begin
/*������������ ��� upload ��������*/
/***** ��������� ���������� *****/
// ������
var maxWidth=500;
//������
var maxHeight=500;
// ����������� ����
var fileTypes=["bmp","gif","png","jpg","jpeg"];
// ����������� ��������
var outImage="previewField";
// ��� ��������
var defaultPic="spacer.gif";
//���� ��������
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

    //��� firefox
    try{
      globalPic.src=what.files[0].getAsDataURL();
    }catch(err){
      globalPic.src=source;
    }
  }else {
    globalPic.src=defaultPic;
    alert("�� ������ ��� �����"+fileTypes.join(", "));
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

//������� ��������(������ �����)
function imgPreviewReset(){
  var field=document.getElementById(outImage);
  field.src=tempPic;
  tempPic='';
  document.getElementById('userfile').value='';
  $('#imgReset').css('display', 'none');
}

// End -->

