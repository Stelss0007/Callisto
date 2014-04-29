var expires = new Date();
expires.setTime(expires.getTime() + 2592000000);
$(document).ready(function(){
    $("#mnu_title1").click(function(){
        if (document.getElementById('mnu_tblock1').style.display == '') val = 0; else val = 1;
        document.cookie="vblock1="+val+"; path=/; expires="+expires;
        document.cookie="vblock1="+val+"; path=/forum/; expires="+expires;
        $("#mnu_tblock1").slideToggle("fast");
        return false;
    });
    $("#mnu_title2").click(function(){
        if (document.getElementById('mnu_tblock2').style.display == '') val = 0; else val = 1;
        document.cookie="vblock2="+val+"; path=/; expires="+expires;
        document.cookie="vblock2="+val+"; path=/forum/; expires="+expires;
        $("#mnu_tblock2").slideToggle("fast");
        return false;
    });
    $("#mnu_title3").click(function(){
        if (document.getElementById('mnu_tblock3').style.display == '') val = 0; else val = 1;
        document.cookie="vblock3="+val+"; path=/; expires="+expires;
        document.cookie="vblock3="+val+"; path=/forum/; expires="+expires;
        $("#mnu_tblock3").slideToggle("fast");
        return false;
    });
    $("#mnu_title4").click(function(){
        if (document.getElementById('mnu_tblock4').style.display == '') val = 0; else val = 1;
        document.cookie="vblock4="+val+"; path=/; expires="+expires;
        document.cookie="vblock4="+val+"; path=/forum/; expires="+expires;
        $("#mnu_tblock4").slideToggle("fast");
        return false;
    });
    $("#mnu_title5").click(function(){
        if (document.getElementById('mnu_tblock5').style.display == '') val = 0; else val = 1;
        document.cookie="vblock5="+val+"; path=/; expires="+expires;
        document.cookie="vblock5="+val+"; path=/forum/; expires="+expires;
        $("#mnu_tblock5").slideToggle("fast");
        return false;
    });
});