{strip}
{* Начальное значение счетчика *}
{counter start=0 print=false}

{foreach item=doc from=$docs_list}
<div id="post-1" class="post-1 post hentry category-- entry">

            {array name='url_vars'}
            {array_append name='url_vars' key='id' value=$doc.id}
            {array_append name='url_vars' key='fid' value=$doc.parent_id}
<h2 class="entry-title">
{*<a href="{mod_url type='user' modname='content' func='doc_view' vars=$url_vars}">*}
<a href="/{$doc.folder_name}/{$doc.child_id}.html">
{$doc.displayname|escape}</a></h2>
    
<div class="entry-byline">

{if $doc.logo}
{*<a href="{mod_url type='user' modname='content' func='doc_view' vars=$url_vars}">*}
<a href="/{$doc.folder_name}/{$doc.child_id}.html">
<IMG width=90 hspace=5 src="{$doc.logo}" align="left" border="0" alt="{$doc.displayname|escape}"></a>
{/if}
        
{if $doc.description}
<div class="entry-content">
<p>{$doc.description|escape|nl2br|truncate:512}</p>
</div>
{/if}
<span class="entry-date">{$doc.pub_datetime|date_format:"%d.%m.%Y"}</span>

</div></div>
{/foreach} 
    
{/strip}