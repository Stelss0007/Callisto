var d = document;
var winIE = (navigator.userAgent.indexOf("Opera")==-1 && (d.getElementById && d.documentElement.behaviorUrns)) ? true : false;
function bodySize()
  {
  if(winIE && d.documentElement.clientWidth)
    {
    sObj = d.getElementsByTagName("body")[0].style;
    sObj.width = (d.documentElement.clientWidth<870) ? "870px" : "100%";
    }
  }

function init()
  {
  if(winIE) { bodySize(); }
  }

onload = init;
if(winIE) { onresize = bodySize; }
