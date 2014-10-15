var openFileTreeNode = [];

$(document).ready( function() {
	fileTreeinit();
});



function fileTreeinit()
  {
  // Hide all subfolders at startup
	$(".php-file-tree").find("UL").hide();
	// Expand/collapse on click
	$(".pft-directory A").click( function() {
    var $parrentUL = $(this).parent().find("UL:first");
		$parrentUL.slideToggle("medium");
    
    var nodeSRC = $(this).parent().attr('data-src');
    
    if(jQuery.inArray(nodeSRC, openFileTreeNode)> -1)
      {
      openFileTreeNode.remove(nodeSRC);
      }
    else 
      {
      openFileTreeNode.push(nodeSRC);
      }
    console.log(openFileTreeNode);
    
		if( $(this).parent().attr('className') == "pft-directory" ) return false;
	});
  }

function fileTreeOpen()
  {
  $.each(openFileTreeNode, function(index, value) { 
    $('*[data-src="'+value+'"] > a').click();
    });
  }