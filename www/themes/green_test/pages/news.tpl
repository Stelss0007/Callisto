
 {foreach from=$news item=new}
 
 	<div style="font-size:12px;padding-bottom:16px;">
    <span style="font-size:11px;">{$new.date}</span><br>
	<span style="font-weight:bold;">{$new.title}</span><br>
	{$new.text}<br>
    <span style="font-size:10px;"><a href="#">подробнее</a></span>
     </div>

 {/foreach}