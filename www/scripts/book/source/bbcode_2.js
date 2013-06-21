var text_enter_url       = "Введите полный URL ссылки";
var text_enter_page      = "Введите номер страницы";
var text_enter_url_name  = "Введите название сайта";
var text_enter_page_name = "Введите описание ссылки";
var text_enter_image    = "Введите полный URL изображения";
var text_enter_email    = "Введите e-mail адрес";
var text_code           = "Использование: [code] Здесь Ваш код.. [/code]";
var text_quote          = "Использование: [quote] Здесь Ваша Цитата.. [/quote]";
var error_no_url        = "Вы должны ввести URL";
var error_no_title      = "Вы должны ввести название";
var error_no_email      = "Вы должны ввести e-mail адрес";
var prompt_start        = "Введите текст для форматирования";
var img_title           = "Введите по какому краю выравнивать картинку (left, center, right)";
var email_title          = "Введите описание ссылки (необязательно)";
var text_pages          = "Страница";
var image_align          = "left";

var selField  = "bbcode_text";
var fombj     = document.getElementById("bbcode_form");

var uagent    = navigator.userAgent.toLowerCase();
var is_safari = ( (uagent.indexOf('safari') != -1) || (navigator.vendor == "Apple Computer, Inc.") );
var is_ie     = ( (uagent.indexOf('msie') != -1) && (!is_opera) && (!is_safari) && (!is_webtv) );
var is_ie4    = ( (is_ie) && (uagent.indexOf("msie 4.") != -1) );
var is_moz    = (navigator.product == 'Gecko');
var is_ns     = ( (uagent.indexOf('compatible') == -1) && (uagent.indexOf('mozilla') != -1) && (!is_opera) && (!is_webtv) && (!is_safari) );
var is_ns4    = ( (is_ns) && (parseInt(navigator.appVersion) == 4) );
var is_opera  = (uagent.indexOf('opera') != -1);
var is_kon    = (uagent.indexOf('konqueror') != -1);
var is_webtv  = (uagent.indexOf('webtv') != -1);

var is_win    =  ( (uagent.indexOf("win") != -1) || (uagent.indexOf("16bit") !=- 1) );
var is_mac    = ( (uagent.indexOf("mac") != -1) || (navigator.vendor == "Apple Computer, Inc.") );
var ua_vers   = parseInt(navigator.appVersion);

var b_open = 0;
var i_open = 0;
var u_open = 0;
var s_open = 0;
var img_open = 0;
var code_open = 0;
var quote_open = 0;
var code_open = 0;
var sql_open = 0;
var html_open = 0;
var left_open = 0;
var center_open = 0;
var right_open = 0;
var hide_open = 0;
var color_open = 0;
var ie_range_cache = '';
var spoiler_open = 0;
var font_open = 0;
var move_open = 0;
var size_open = 0;
var url_open = 0;

var bbtags   = new Array();

function stacksize(thearray)
{
	for (i = 0; i < thearray.length; i++ )
	{
		if ( (thearray[i] == "") || (thearray[i] == null) || (thearray == 'undefined') )
		{
			return i;
		}
	}

	return thearray.length;
};

function pushstack(thearray, newval)
{
	arraysize = stacksize(thearray);
	thearray[arraysize] = newval;
};

function popstack(thearray)
{
	arraysize = stacksize(thearray);
	theval = thearray[arraysize - 1];
	delete thearray[arraysize - 1];
	return theval;
};

function setFieldName(which)
{
            if (which != selField)
            {
				allcleartags();
                selField = which;

            }
};


function cstat()
{
	var c = stacksize(bbtags);

	if ( (c < 1) || (c == null) ) {
		c = 0;
	}

	if ( ! bbtags[0] ) {
		c = 0;
	}


};


function closeall()
{
	if (bbtags[0])
	{
		while (bbtags[0])
		{
			tagRemove = popstack(bbtags);
			var closetags = "[/" + tagRemove + "]";

			eval ("fombj." +selField+ ".value += closetags");

			//if ( (tagRemove != 'font') && (tagRemove != 'size') )
			//{
				eval(tagRemove + "_open = 0");
				document.getElementById( 'b_' + tagRemove ).className = 'editor_button';

			//}
		}
	}

	bbtags = new Array();

};

function allcleartags()
{
	if (bbtags[0])
	{
		while (bbtags[0])
		{
			tagRemove = popstack(bbtags);

				eval(tagRemove + "_open = 0");
				document.getElementById( 'b_' + tagRemove ).className = 'editor_button';

		}
	}

	bbtags = new Array();

};

function emoticon(theSmilie)
{
	doInsert(" " + theSmilie + " ", "", false);
};

function pagebreak()
{
	doInsert("[hr]", "", false);
};

function add_code(NewCode)
{
    fombj.selField.value += NewCode;
    fombj.selField.focus();
};

function simpletag(thetag)
{
	var tagOpen = eval(thetag + "_open");


		if (tagOpen == 0)
		{
			if(doInsert("[" + thetag + "]", "[/" + thetag + "]", true))
			{
				eval(thetag + "_open = 1");
				document.getElementById( 'b_' + thetag ).className = 'editor_buttoncl';

				pushstack(bbtags, thetag);
				cstat();

			}
		}
		else
		{
			lastindex = 0;

			for (i = 0 ; i < bbtags.length; i++ )
			{
				if ( bbtags[i] == thetag )
				{
					lastindex = i;
				}
			}

			while (bbtags[lastindex])
			{
				tagRemove = popstack(bbtags);
				doInsert("[/" + tagRemove + "]", "", false);


				if ( (tagRemove != 'font') && (tagRemove != 'size') )
				{
					eval(tagRemove + "_open = 0");
					document.getElementById( 'b_' + tagRemove ).className = 'editor_button';
				}
			}

			cstat();
		}

};
function tag_url()
{
    var FoundErrors = '';
	var thesel ='';
	if ( (ua_vers >= 4) && is_ie && is_win)
	{
	thesel = document.selection.createRange().text;
	} else thesel ='My Webpage';

    if (!thesel) {
        thesel ='My Webpage';
    }

    var enterURL   = prompt(text_enter_url, "http://");
    var enterTITLE = prompt(text_enter_url_name, thesel);

    if (!enterURL) {
        FoundErrors += " " + error_no_url;
    }
    if (!enterTITLE) {
        FoundErrors += " " + error_no_title;
    }

    if (FoundErrors) {
        alert("Error!"+FoundErrors);
        return;
    }

	doInsert("[url="+enterURL+"]"+enterTITLE+"[/url]", "", false);
};

function tag_image()
{
    var FoundErrors = '';
    var enterURL   = prompt(text_enter_image, "http://");

    var Title = prompt(img_title, image_align);

    if (!enterURL) {
        FoundErrors += " " + error_no_url;
    }

    if (FoundErrors) {
        alert("Error!"+FoundErrors);
        return;
    }

if (Title == "")
           {
	doInsert("[img]"+enterURL+"[/img]", "", false);
           }
else {
if (Title == "center") {
	doInsert("[center][img]"+enterURL+"[/img][/center]", "", false);
}
else {
	doInsert("[img="+Title+"]"+enterURL+"[/img]", "", false);
	}
 }
};

function tag_video()
{
    var FoundErrors = '';

	var thesel ='';
	if ( (ua_vers >= 4) && is_ie && is_win)
	{
	thesel = document.selection.createRange().text;
	} else thesel ='http://';

    if (!thesel) {
        thesel ='http://';
    }

    var enterURL = prompt(text_enter_url, thesel);

    if (!enterURL) {
        FoundErrors += " " + error_no_url;
    }

    if (FoundErrors) {
        alert("Error!"+FoundErrors);
        return;
    }

	doInsert("[video="+enterURL+"]", "", false);
};

function tag_audio()
{
    var FoundErrors = '';

	var thesel ='';
	if ( (ua_vers >= 4) && is_ie && is_win)
	{
	thesel = document.selection.createRange().text;
	} else thesel ='http://';

    if (!thesel) {
        thesel ='http://';
    }

    var enterURL = prompt(text_enter_url, thesel);

    if (!enterURL) {
        FoundErrors += " " + error_no_url;
    }

    if (FoundErrors) {
        alert("Error!"+FoundErrors);
        return;
    }

	doInsert("[audio="+enterURL+"]", "", false);
};

function tag_email()
{
    var emailAddress = prompt(text_enter_email, "");

    if (!emailAddress) {
		alert(error_no_email);
		return;
	}

	var thesel ='';
	if ( (ua_vers >= 4) && is_ie && is_win)
	{
	thesel = document.selection.createRange().text;
	} else thesel ='';

    if (!thesel) {
        thesel ='';
    }

	var Title = prompt(email_title, thesel);

if (!Title) Title = emailAddress;

	doInsert("[email="+emailAddress+"]"+Title+"[/email]", "", false);
};

function doInsert(ibTag, ibClsTag, isSingle)
  {
	var isClose = false;
	var obj_ta = eval('fombj.'+ selField);

	if ( (ua_vers >= 4) && is_ie && is_win)
	{
		if (obj_ta.isTextEdit)
		{
			obj_ta.focus();
			var sel = document.selection;
			var rng = ie_range_cache ? ie_range_cache : sel.createRange();
			rng.colapse;
			if((sel.type == "Text" || sel.type == "None") && rng != null)
			{
				if(ibClsTag != "" && rng.text.length > 0)
					ibTag += rng.text + ibClsTag;
				else if(isSingle)
					isClose = true;

				rng.text = ibTag;
			}
		}
		else
		{
			if(isSingle)
			{
				isClose = true;
			}

			obj_ta.value += ibTag;
		}
		rng.select();
	ie_range_cache = null;

	}
	else if ( obj_ta.selectionEnd )
	{
		var ss = obj_ta.selectionStart;
		var st = obj_ta.scrollTop;
		var es = obj_ta.selectionEnd;

		if (es <= 2)
		{
			es = obj_ta.textLength;
		}

		var start  = (obj_ta.value).substring(0, ss);
		var middle = (obj_ta.value).substring(ss, es);
		var end    = (obj_ta.value).substring(es, obj_ta.textLength);

		if (obj_ta.selectionEnd - obj_ta.selectionStart > 0)
		{
			middle = ibTag + middle + ibClsTag;
		}
		else
		{
			middle = ibTag + middle;

			if (isSingle)
			{
				isClose = true;
			}
		}

		obj_ta.value = start + middle + end;

		var cpos = ss + (middle.length);

		obj_ta.selectionStart = cpos;
		obj_ta.selectionEnd   = cpos;
		obj_ta.scrollTop      = st;


	}
	else
	{
		if (isSingle)
		{
			isClose = true;
		}

		obj_ta.value += ibTag;
	}

	obj_ta.focus();
	return isClose;
};

function getOffsetTop(obj)
{
	var top = obj.offsetTop;

	while( (obj = obj.offsetParent) != null )
	{
		top += obj.offsetTop;
	}

	return top;
};

function getOffsetLeft(obj)
{
	var top = obj.offsetLeft;

	while( (obj = obj.offsetParent) != null )
	{
		top += obj.offsetLeft;
	}

	return top;
};
function ins_color()
{

	if (color_open == 0) {
		var buttonElement = document.getElementById('b_color');
		document.getElementById(selField).focus();

		if ( is_ie )
		{
			document.getElementById(selField).focus();
			ie_range_cache = document.selection.createRange();
		}

		var iLeftPos  = getOffsetLeft(buttonElement);
		var iTopPos   = getOffsetTop(buttonElement) + (buttonElement.offsetHeight + 3);

		document.getElementById('cp').style.left = (iLeftPos) + "px";
		document.getElementById('cp').style.top  = (iTopPos)  + "px";

		if (document.getElementById('cp').style.visibility == "hidden")
		{
			document.getElementById('cp').style.visibility = "visible";
			document.getElementById('cp').style.display    = "block";
		}
		else
		{
			document.getElementById('cp').style.visibility = "hidden";
			document.getElementById('cp').style.display    = "none";
			ie_range_cache = null;
		}
	}
	else
	{
			lastindex = 0;

			for (i = 0 ; i < bbtags.length; i++ )
			{
				if ( bbtags[i] == 'color' )
				{
					lastindex = i;
				}
			}

			while (bbtags[lastindex])
			{
				tagRemove = popstack(bbtags);
				doInsert("[/" + tagRemove + "]", "", false);
				eval(tagRemove + "_open = 0");
				document.getElementById( 'b_' + tagRemove ).className = 'editor_button';
			}
	}
};
function setColor(color)
{

		if ( doInsert("[color=" +color+ "]", "[/color]", true ) )
		{
			color_open = 1;
			document.getElementById( 'b_color' ).className = 'editor_buttoncl';
			pushstack(bbtags, "color");
		}

	document.getElementById('cp').style.visibility = "hidden";
	document.getElementById('cp').style.display    = "none";
    cstat();
};



function ins_size()
{

	if (size_open == 0) {
		var buttonElement = document.getElementById('b_size');
		document.getElementById(selField).focus();

		if ( is_ie )
		{
			document.getElementById(selField).focus();
			ie_range_cache = document.selection.createRange();
		}

		var iLeftPos  = getOffsetLeft(buttonElement);
		var iTopPos   = getOffsetTop(buttonElement) + (buttonElement.offsetHeight + 3);

		document.getElementById('sizepanel').style.left = (iLeftPos) + "px";
		document.getElementById('sizepanel').style.top  = (iTopPos)  + "px";

		if (document.getElementById('sizepanel').style.visibility == "hidden")
		{
			document.getElementById('sizepanel').style.visibility = "visible";
			document.getElementById('sizepanel').style.display    = "block";
		}
		else
		{
			document.getElementById('sizepanel').style.visibility = "hidden";
			document.getElementById('sizepanel').style.display    = "none";
			ie_range_cache = null;
		}
	}
	else
	{
			lastindex = 0;

			for (i = 0 ; i < bbtags.length; i++ )
			{
				if ( bbtags[i] == 'size' )
				{
					lastindex = i;
				}
			}

			while (bbtags[lastindex])
			{
				tagRemove = popstack(bbtags);
				doInsert("[/" + tagRemove + "]", "", false);
				eval(tagRemove + "_open = 0");
				document.getElementById( 'b_' + tagRemove ).className = 'editor_button';
			}
	}
};
function setSize(size)
{

		if ( doInsert("[size=" +size+ "]", "[/size]", true ) )
		{
			size_open = 1;
			document.getElementById( 'b_size').className = 'editor_buttoncl';
			pushstack(bbtags, "size");
		}

	document.getElementById('sizepanel').style.visibility = "hidden";
	document.getElementById('sizepanel').style.display    = "none";
    cstat();
};


function ins_font()
{

	if (font_open == 0) {
		var buttonElement = document.getElementById('b_font');
		document.getElementById(selField).focus();

		if ( is_ie )
		{
			document.getElementById(selField).focus();
			ie_range_cache = document.selection.createRange();
		}

		var iLeftPos  = getOffsetLeft(buttonElement);
		var iTopPos   = getOffsetTop(buttonElement) + (buttonElement.offsetHeight + 3);

		document.getElementById('fontpanel').style.left = (iLeftPos) + "px";
		document.getElementById('fontpanel').style.top  = (iTopPos)  + "px";

		if (document.getElementById('fontpanel').style.visibility == "hidden")
		{
			document.getElementById('fontpanel').style.visibility = "visible";
			document.getElementById('fontpanel').style.display    = "block";
		}
		else
		{
			document.getElementById('fontpanel').style.visibility = "hidden";
			document.getElementById('fontpanel').style.display    = "none";
			ie_range_cache = null;
		}
	}
	else
	{
			lastindex = 0;

			for (i = 0 ; i < bbtags.length; i++ )
			{
				if ( bbtags[i] == 'font' )
				{
					lastindex = i;
				}
			}

			while (bbtags[lastindex])
			{
				tagRemove = popstack(bbtags);
				doInsert("[/" + tagRemove + "]", "", false);
				eval(tagRemove + "_open = 0");
				document.getElementById( 'b_' + tagRemove ).className = 'editor_button';
			}
	}
};
function setFont(font)
{

		if ( doInsert("[font=" +font+ "]", "[/font]", true ) )
		{
			font_open = 1;
			document.getElementById( 'b_font' ).className = 'editor_buttoncl';
			pushstack(bbtags, "font");
		}

	document.getElementById('fontpanel').style.visibility = "hidden";
	document.getElementById('fontpanel').style.display    = "none";
    cstat();
};


function pagelink()
{
    var FoundErrors = '';
	var thesel ='';
	if ( (ua_vers >= 4) && is_ie && is_win)
	{
	thesel = document.selection.createRange().text;
	} else thesel = text_pages;

    if (!thesel) {
        thesel = text_pages;
    }

    var enterURL   = prompt(text_enter_page, "1");
    var enterTITLE = prompt(text_enter_page_name, thesel);

    if (!enterURL) {
        FoundErrors += " " + error_no_url;
    }
    if (!enterTITLE) {
        FoundErrors += " " + error_no_title;
    }

    if (FoundErrors) {
        alert("Error!"+FoundErrors);
        return;
    }

	doInsert("[page="+enterURL+"]"+enterTITLE+"[/page]", "", false);
};


function insert_font(value, tag)
  {
  if (value == 0)
    {
   	return;
	  }

	if ( doInsert("[" +tag+ "=" +value+ "]", "[/" +tag+ "]", true ) )
  	{
		pushstack(bbtags, tag);
  	}
  fombj.bbfont.selectedIndex  = 0;
  fombj.bbsize.selectedIndex  = 0;
  };

