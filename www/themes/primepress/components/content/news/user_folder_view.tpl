{strip}
{*
Defines of access levels :
ACCESS_INVALID   -1
ACCESS_NONE       0
ACCESS_OVERVIEW  10
ACCESS_READ      20
ACCESS_COMMENT   30
ACCESS_ADD       40
ACCESS_EDIT      50
ACCESS_DELETE    60
ACCESS_ADMIN     70
*}
{if $curuser_sec_level>=50}
<div>
	{include file='modules/content/themes/default/include/folder_view_adminBtn.tpl'}
	{assign var = 'folder_view_adminBtn_inserted' value = true}
</div>
{/if}

{* Содержание *}
{if $content}
<div>
{$content}
</div>

{/if}



{* Список документов *}
{if $sub_docs_list}



{* Инициализируем счетчик доукментов *}
{math equation="doc_perpage * (page_current-1)" doc_perpage=$doc_perpage page_current=$page_current assign='start_doc_num'}
{counter start=$start_doc_num print=false}


{foreach item=doc from=$sub_docs_list name=docs}
<div id="post-1" class="post-1 post hentry category-- entry">
{* Формируем масив переменные для урла *}
{array name='url_vars'}
{array_append name='url_vars' key='id' value=$doc.id}
{array_append name='url_vars' key='fid' value=$id}

{if $curuser_sec_level>=70}
{if $doc.active!=true}
<img src="/public/images/system/notactive.gif" width="16" height="16" alt="Не активирован" border=0 style="padding-right:10px;">
{/if}
{/if}
{if ($name)}
<h2 class="entry-title"><a href="{$name}/{$doc.id}.html">{$doc.displayname|escape}</a></h2>
{else}
<h2 class="entry-title"><a href="{mod_url type='user' modname='content' func='doc_view' vars=$url_vars}">{$doc.displayname|escape}</a></h2>
{/if}



{if $curuser_sec_level>=70}
{* добовляем ссылки для передвижки весов*}
{if $doc.weight_moveup_url}
<a href="{$doc.weight_moveup_url}"><img border="0" src="/public/images/system/up.gif"></a>
{/if}

{if $doc.weight_movedown_url}
<a href="{$doc.weight_movedown_url}"><img border="0" src="/public/images/system/down.gif"></a>
{/if}

{* добавляем ссылки для редактирования и удаления*}

<a href="{mod_url type='admin' modname='content' func='doc_modify' vars=$url_vars}" title="{#editdoc#}">
<img src="/public/images/system/edit.gif" width="16" height="16" alt="{#editdoc#}" border=0>
</a>
<a href="{mod_url type='admin' modname='content' func='doc_links_dg' vars=$url_vars}" title="{#managelink#}">
<img src="/public/images/system/links.png" width="16" height="16" alt="{#managelink#}" border=0>
</a>
<a href="{mod_url type='admin' modname='content' func='doc_copy_dg' vars=$url_vars}" title="{#copydoc#}">
<img src="/public/images/system/copy.gif" width="16" height="16" alt="{#copydoc#}" border=0>
</a>

<a href="{mod_url type='admin' modname='content' func='doc_confirm_delete' vars=$url_vars}" title="{#deletedoc#}">
<img src="/public/images/system/del.gif" width="16" height="16" alt="{#deletedoc#}" border=0>
</a>

{/if}


<div class="entry-byline">
<span class="entry-date">{$doc.pub_datetime|date_format:"%d.%m.%Y"}</span>
{if $doc.logo}
<div><IMG src="{$doc.logo}" border=0 alt="{$doc.displayname|escape}"></div>
{/if}
<div class="entry-content">
{if $doc.description}
<p>{$doc.description|strip_tags|nl2br|truncate:70}</p>
{else}
<p>{$doc.content|strip_tags|nl2br|truncate:70}</p>
{/if}
</div>
</div>



</div>
{/foreach}
{/if}



{* Список разделов *}
{if $sub_folders_list}

{foreach item=folder from=$sub_folders_list name=folders}
 
<div id="post-1" class="post-1 post hentry category-- entry">

{* Формируем масив переменные для урла *}
{array name='url_vars'}
{array_append name='url_vars' key='id' value=$folder.id}

{* Если раздел не активен ставим хрестик *}
{if $curuser_sec_level>=70}
{if $folder.active!=true}
<img src="/public/images/system/notactive.gif" width="16" height="16" alt="Не активирован" border=0 style="padding-right:10px;">
{/if}
{/if}
{if $folder.name}
<h2 class="entry-title"><a href="/{$folder.name}">{$folder.displayname|escape}</a></h2>
{else}
<h2 class="entry-title"><a href="{mod_url type='user' modname='content' func='folder_view' vars=$url_vars}">{$folder.displayname}</a></h2>
{/if}
{if $curuser_sec_level>=70}
<span>
{* добавляем ссылки для передвижки весов*}
{if $folder.weight_moveup_url}
<a href="{$folder.weight_moveup_url}"><img border="0" src="/public/images/system/up.gif"></a>
{/if}

{if $folder.weight_movedown_url}
<a href="{$folder.weight_movedown_url}"><img border="0" src="/public/images/system/down.gif"></a>
{/if}

{* добавляем ссылки для редактирования и удаления*}
<a href="{mod_url type='admin' modname='content' func='folder_modify' vars=$url_vars}">
<img src="/public/images/system/edit.gif" width="16" height="16" alt="{#editfolder#}" border=0>
</a>

<a href="{mod_url type='admin' modname='content' func='folder_copy_dg' vars=$url_vars}">
<img src="/public/images/system/copy.gif" width="16" height="16" alt="{#copyfolder#}" border=0>
</a>

<a href="{mod_url type='admin' modname='content' func='folder_confirm_delete' vars=$url_vars}">
<img src="/public/images/system/del.gif" width="16" height="16" alt="{#deletefolder#}" border=0>
</a>
</span>
<br>
{/if}
<div class="entry-byline"><div class="entry-content">
{if $folder.description}            
{$folder.description|strip_tags|nl2br|truncate:70}
{else}
{$folder.content|strip_tags|nl2br|truncate:70}
{/if}
</div></div>
</div>
{/foreach}
{/if}



<div style="margin:50px 0 0 30px;">
{* Навигационная панель *}
  {if $page_total>1}
	{if $name}
    {include file='modules/content/themes/default/folder_view_NPanel_short.tpl'}
	{else}
{include file='modules/content/themes/default/folder_view_NPanel.tpl'}
{/if}
  {/if}
{* END Навигационная панель *}


{* URL добавление документа/раздела *}
  {if $curuser_sec_level>=70}
  <div>
  
  {* Формируем масив переменные для урла *}
  {array name='url_vars'}
  {array_append name='url_vars' key='fid' value=$id}
  <a href="{mod_url type='admin' modname='content' func='doc_new' vars=$url_vars}">{#adddoc#}</a>
  &nbsp;|&nbsp;
  {array name='url_vars'}
  {array_append name='url_vars' key='id' value=$id}
  <a href="{mod_url type='admin' modname='content' func='folder_new' vars=$url_vars}">{#addfolder#}</a>
  </div>
  {/if}
</div>

{/strip}
