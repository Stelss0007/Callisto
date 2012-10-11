<?php
$file_src = 'D:\www\callisto_2\www\modules\test\index.php';
$file = file_get_contents($file_src);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns = "http://www.w3.org/1999/xhtml">
  <head>
    <title>Untitled Page</title>
    <style type = "text/css">
      #container
      {
        width: 30px;
        float: left;
        color: Gray;
        font-family: Courier New;
        font-size: 14px;
        overflow: hidden;
        height: 400px;
        position: relative;
        top: 5px;
        background-color: #d9d9d9;
      }
      #divlines 
      {
        position: absolute;
        text-align: right;
        margin-left: 5px;
      }
      #text1 
      {
        overflow-x: scroll;
        height: 400px;
        font-family: Courier New;
        font-size: 14px;
        width: 800px;
      }
    </style>
  </head>
  <body>
    <table height="100%" style="border: 1px solid #000; min-height: 100%">
      <tr>
        <td colspan="2" height="70">
          menu
        </td>
      </tr>
    
      <tr>
        <td height="100%" width="300">
          Left menu
        </td>
        <td>
          <div style="width: 100%; height: 100%; background-color: #d9d9d9;">
            <div id = "container">
              <div id = "divlines">
              </div>
            </div>
            <textarea id = "text1" cols = "50" wrap = "off"><?=$file?></textarea>
          </div>
        </td>

      </tr>
    </table>
    <script type = "text/javascript">
      var lines = document.getElementById("divlines");
      var txtArea = document.getElementById("text1");
      window.onload = function() {
        refreshlines();
        txtArea.onscroll = function () {
          lines.style.top = -(txtArea.scrollTop) + "px";
          return true;
        }
        txtArea.onkeyup = function () {
          refreshlines();
          return true;
        }
      }

      function refreshlines() {
        var nLines = txtArea.value.split("\n").length;
        lines.innerHTML = ""
        for (i = 1;
        i<=nLines;
        i++) {
          lines.innerHTML = lines.innerHTML + i + "." + "<br />";
        }
        lines.style.top = -(txtArea.scrollTop) + "px";
      }
    </script>
  </body>
</html>
