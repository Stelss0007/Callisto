/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
////////////////////////////////////////////////////////////////////////////////
///////////////////////Цитатник/////////////////////////////////////////////////
/*Для скопирования в буфер (цитатник), типа плагин))*/



jQuery.fn.addtocopy = function(usercopytxt)
  {
  var options = '11111';//{htmlcopytxt: '<br>More: <a href="'+window.location.href+'">Источник</a><br>', minlen: 25, addcopyfirst: false}
  $.extend(options, usercopytxt);
  var copy_sp = document.createElement('span');
  copy_sp.id = 'ctrlcopy';
  copy_sp.innerHTML = "<br>Детальнее: <a href='"+window.location.href+"'>Источник</a><br>";//options.htmlcopytxt;

  return this.each(function(){
    $(this).mousedown(function(){
      $('#ctrlcopy').remove();
    });

    $(this).mouseup(function(e){

      //если флаг быстрые цитаты установлен
      if($('input[name=hot_quote]').attr('checked'))
        {
        var html="";
        var txt="";
        if(window.getSelection)
          {	//good times
          var slcted=window.getSelection();
          var seltxt=slcted.toString();
          if(!seltxt||seltxt.length<options.minlen) return;
          var nslct = slcted.getRangeAt(0);
          seltxt = nslct.cloneRange();
          seltxt.collapse(options.addcopyfirst);
          seltxt.insertNode(copy_sp);
          if (!options.addcopyfirst) nslct.setEndAfter(copy_sp);
          slcted.removeAllRanges();
          slcted.addRange(nslct);

          rng=window.getSelection();
          if (rng.rangeCount > 0 && window.XMLSerializer)
            {
            rng=rng.getRangeAt(0);
            html=new XMLSerializer().serializeToString(rng.cloneContents());
            txt=rng.toString();
            }
          }
        else if(document.selection)
          {	//bad times
          var slcted = document.selection;
          var nslct=slcted.createRange();
          var seltxt=nslct.text;
          if (!seltxt||seltxt.length<options.minlen) return;
          seltxt=nslct.duplicate();
          seltxt.collapse(options.addcopyfirst);
          seltxt.pasteHTML(copy_sp.outerHTML);
          if (!options.addcopyfirst)
            {
            nslct.setEndPoint("EndToEnd",seltxt);
            nslct.select();
            }
          rng=document.selection.createRange();
          html=rng.htmlText||"";
          }
        //alert('Вы скопировали текст\n'+ html);
        //alert( e.pageY);




        $('#quote_view_url').val(window.location.href);
        $('#quote_content').val(html);
        $('#savecontent').val(html);
        $('#quoteDiv').html(html);

        $.closeWindow("winQuote");

        $.newWindow({
                     id:"winQuote",
                     title:"Быстрые цитаты ",
                     content: $('#WindowQuote').html(),
                     width: 400,
                     height: 280,
                     resizeable: false,
                     maximizeButton: false
                    });

        $('#winQuote').center();
        //$('#quoteFrame').contents().find("body").html(html);
        }
      });

    });
  }

//Запускаем плагин
$(function()
{
  $("#page_content").addtocopy({
    htmlcopytxt: '<br>Подробнее: <a href="'+window.location.href+'">'+window.location.href+'</a>'
  });
});

//ADD QUOTE
function sendMyQuote()
  {
  $.post("/index.php",
    {
    module: "quote",
    type: "ajax",
    func: "create",
    quote_module: $('#quote_module').val(),
    quote_key_a: $('#quote_key_a').val(),
    quote_key_b:$('#quote_key_b').val(),
    quote_auth_user_id: $('#quote_auth_user_id').val(),
    quote_name: $('#quote_name').val(),
    quote_auth_name: $('#quote_auth_name').val(),
    quote_auth_url: $('#quote_auth_url').val(),
    quote_content: $('#quote_content').val()
    },
    function(data)
      {
      alert("Данные успешно добавлены");
      $.closeWindow("winQuote");
      }
    );
  }

//FULL TEXT OF QUOTE
function quoteFull(idDiv,idQuote, type)
  {
  $('#loading-layer').css('display','block').center();
  $.post("/index.php",
    {
    module: "quote",
    type: "ajax",
    func: "fullContent",
    id: idQuote,
    lstType:type
    },
  function(data)
    {
    $('#'+idDiv).html(data);
    $('#loading-layer').css('display','none')
    }
  );
// $('#'+idDiv).load("index.php?module=quote&type=ajax&func=fullContent&id="+idQuote);
  }

// SET NICE QUOTE
function quoteNice(idQuote)
  {

  $.post("/index.php",
    {
    module: "quote",
    type: "ajax",
    func: "nice",
    id: idQuote
    },
  function(data)
    {
    alert(data);
    $val=parseInt($('#quote_nice').html())+1;
    $('#quote_nice').html($val);
    setStatusBadNice();
    }
  );
// $('#'+idDiv).load("index.php?module=quote&type=ajax&func=fullContent&id="+idQuote);
  }

// SET BAD QUOTE
  function quoteBad(idQuote)
  {

  $.post("/index.php",
    {
    module: "quote",
    type: "ajax",
    func: "bad",
    id: idQuote
    },
  function(data)
    {
    alert(data);
    val=parseInt($('#quote_bad').html())+1;
    $('#quote_bad').html(val);
    setStatusBadNice();
    }
  );
// $('#'+idDiv).load("index.php?module=quote&type=ajax&func=fullContent&id="+idQuote);
  }



  function setStatusBadNice()
    {
    var nice_w=0;
    var bad_w=0;

    bad_count=parseInt($('#quote_bad').html());
    nice_count=parseInt($('#quote_nice').html());

    nice_w=Math.round(nice_count/(nice_count +  bad_count)*100);
    bad_w=100-nice_w;

    $('#div_nice').css('width',nice_w+'%');
    $('#div_bad').css('width',bad_w+'%');
    }


