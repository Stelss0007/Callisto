<script language="JavaScript" src="/scripts/tigra_calendar/calendar_db.js"></script>
<link rel="stylesheet" href="/scripts/tigra_calendar/calendar.css">
 <form name="doc_modify_form" action="{mod_url type='admin' modname='content' func='doc_update'}" method="post"  enctype="multipart/form-data">
  <input type="hidden" name="id" value="{$id}">
  <input type="hidden" name="fid" value="{$fid}">
  <input type="hidden" name="http_referer" value="{$http_referer}">

    <table class="outer" cellSpacing="1" cellPadding="4">

        <tr>
          <th>{#editingdoc#}</th>
        </tr>

      {* Убираем
        <tr vAlign="top" align="left">
          <td class="head">{#folder#}</td>
          <td class="even">

          {* Формируем плоский масив для вункции html_options * }
          {array name='flat_folderslist'}

          {foreach item=folder from=$folders_list}
            {array_append name='flat_folderslist' key=$folder.id value=$folder.displayname|tree:$folder.level}
          {/foreach}

      
      <select name=fid>
      {html_options options=$flat_folderslist selected=$fid}
      </select>
      

    </td>
        </tr>
        *}

        <tr vAlign="top" align="left">
          <td class="head">{#docdisplayname#}<br><input maxLength="255" size="60" name="displayname" value="{$displayname|escape}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#description#}<br><textarea name="description" rows="5" cols="60">{$description|escape}</textarea></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#content#}<br>
	{if ($editor==2)  or (!$editor)}
            {texteditor name="content" text=$content}
	{else}
	<textarea name="content" rows="22" cols="60">
{$content}
</textarea>
{/if}
          </td>
        </tr>

       <tr vAlign="top" align="left">
          <td class="head">Редактор<br>
<select name="editor" onChange="window.location='/index.php?module=content&type=admin&func=doc_modify&id={$id}&fid={$fid}&editor='+this.value">
<option value="2" {if ($editor==2) or (!$editor)}selected{/if}>TinyMCE</option>
<option value="1" {if $editor==1}selected{/if}>нет</option>
</select>
</td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#logo#}<br>
            <input maxLength="60" size="50" name="logo" value="{$logo}">&nbsp;
            {imagebrowse action="document.doc_modify_form.logo.value"}
          </td>
        </tr>
        <tr vAlign="top" align="left">
          <td class="head">Шапка<br>
            <input name="header" type="file">
          </td>
        </tr>
        <tr vAlign="top" align="left">
          <td class="head">{#author#}<br><input maxLength="60" size="50" name="author" value="{$author}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#author_email#}<br><input maxLength="60" size="50" name="author_email" value="{$author_email}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#author_url#}<br><input maxLength="60" size="50" name="url" value="{$url}"></td>
        </tr>

        {array name='asc_yes_no'}
        {array_append name='asc_yes_no' key='1' value='Да'}
        {array_append name='asc_yes_no' key='0' value='Нет'}

        <tr vAlign="top" align="left">
          <td class="head">{#active#}<br>
            {html_radios name="active" options=$asc_yes_no checked=$active separator=" "}
          </td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#pub_datetime#}<br>
     {*     {html_select_date time=$pub_datetime start_year="-1" end_year="+1" field_order=DMY prefix='pub_date_'}&nbsp;*}

	<input type="text" name="pub_date" id="pub_date" value={$pub_datetime|date_format:"%Y-%m-%d"}>
{literal}
	<script language="JavaScript">

	var A_CALTPL = {
		'months' : ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
		'weekdays' : ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'],
		'yearscroll': true,
		'weekstart': 1,
		'centyear'  : 70,
		'imgpath' : '/scripts/tigra_calendar/img/'
	}
	
	new tcal ({
		// if referenced by ID then form name is not required
		'controlname': 'pub_date'
	}, A_CALTPL);

	
	</script>

{/literal}
          {#time#}: {html_select_time time=$pub_datetime display_seconds=false prefix='pub_time_'}
          </td>
        </tr>


        <tr vAlign="top" align="center">
          <td class="foot">
            <input type="submit" value="{#edit#}" name="submit">
          </td>
        </tr>

    </table>
  </form>

<br>
{* фотки *}
<table width=100%>
 <thead>
      <tr>
        <th colSpan="4">Фотографии</th>
      </tr>
    </thead>

    <tbody>
      {if $images_list}
        {foreach item=image from=$images_list}
        {cycle name="subdls" values="even,odd" assign="class" print=false}
          {* Формируем масив переменные для урла *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$image.id}
          <tr>
            <td class="{$class}" align="center">
              <a href="{mod_url type='user' modname='content' func='image_view' vars=$url_vars}">
                <img width="{$image.image_w}" height="{$image.image_h}" src="{$image.thumb_url}" alt="{$image.image_displayname|escape}" border=0>
              </a>
            </td>

            <td class="{$class}" valign="top">
              <a href="{mod_url type='user' modname='content' func='image_view' vars=$url_vars}">{$image.image_displayname|escape}</a>
                {if $image.image_description}
                  <p>{$image.image_description|escape}</p>
                {/if}
            </td>

            <td class="{$class}" align="center" nowrap>
              {if $image.weight_moveup_url}
                <a href="{$image.weight_moveup_url}"><img border="0" src="/files/shared/images/system/up.gif"></a>
              {/if}
              {if $image.weight_moveup_url && $image.weight_movedown_url}
                &nbsp;
              {/if}
              {if $image.weight_movedown_url}
                <a href="{$image.weight_movedown_url}"><img border="0" src="/files/shared/images/system/down.gif"></a>
              {/if}
            </td>

            <td class="{$class}" align="center" nowrap>
              <a href="{mod_url type='admin' modname='content' func='image_modify' vars=$url_vars}"><img border="0" src="/files/shared/images/system/edit.gif" alt="Редактировать"></a>&nbsp;
              <a href="{mod_url type='admin' modname='content' func='image_confirm_delete' vars=$url_vars}"><img border="0" src="/files/shared/images/system/del.gif" alt="Удалить"></a>

</td>
          </tr>
        {/foreach}

      {else}
        <tr>
          <td colSpan="4" align="center" class="even">Нет фотографий</td>
        </tr>
      {/if}
    </tbody>
</table>



{* Дальше идут фишки для редактирования документы вложенные в документ *}
  <table class="outer" cellSpacing="1" cellPadding="4">
    <colgroup>
      <col width="90%">
      <col width="5%">
      <col width="5%">
    </colgroup>

    <thead>
      <tr>
        <th colSpan="4">{#pagesindoc#}</th>
      </tr>
    </thead>

    <tbody>
      {if $subdocs_list}
        {foreach item=subdoc from=$subdocs_list}
        {cycle name="subdls" values="even,odd" assign="class" print=false}
          {* Формируем масив переменные для урла *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$subdoc.id}
          <tr>
            <td class="{$class}">
              <a href="{mod_url type='user' modname='content' func='subdoc_view' vars=$url_vars}">{$subdoc.displayname|escape|tree:$subdoc.level}</a>
            </td>

            <td class="{$class}" align="center" nowrap>
              {if $subdoc.weight_moveup_url}
                <a href="{$subdoc.weight_moveup_url}"><img border="0" src="/files/shared/images/system/up.gif"></a>
              {/if}
              {if $subdoc.weight_moveup_url && $subdoc.weight_movedown_url}
                &nbsp;
              {/if}
              {if $subdoc.weight_movedown_url}
                <a href="{$subdoc.weight_movedown_url}"><img border="0" src="/files/shared/images/system/down.gif"></a>
              {/if}
            </td>

            <td class="{$class}" align="center" nowrap>
              <a href="{mod_url type='admin' modname='content' func='subdoc_modify' vars=$url_vars}"><img border="0" src="/files/shared/images/system/edit.gif" alt="{#edit#}"></a>&nbsp;
              <a href="{mod_url type='admin' modname='content' func='subdoc_new' vars=$url_vars}"><img border="0" src="/files/shared/images/system/add.gif" alt="{#add#}"></a>&nbsp;
              <a href="{mod_url type='admin' modname='content' func='subdoc_confirm_delete' vars=$url_vars}"><img border="0" src="/files/shared/images/system/del.gif" alt="{#delete#}"></a>
            </td>
          </tr>
        {/foreach}
        <tr>
          <td colSpan="4" align="left" class="even">
            {#for_subpages_tree#}
            <br>
            {#for_subpages_list#}
          </td>
        </tr>

      {else}
        <tr>
          <td colSpan="4" align="center" class="even">Нет страниц вложенных в документ</td>
        </tr>
      {/if}
    </tbody>
  </table>

<br>

{* URL добавление под документа *}
   {if $curuser_sec_level>=70}
     <center>
        [&nbsp;
        {* Формируем масив переменные для урла *}
        {array name='url_vars'}
        {array_append name='url_vars' key='id' value=$id}
        <a href="{mod_url type='admin' modname='content' func='subdoc_new' vars=$url_vars}">{#addsubpage#}</a>
        &nbsp;]
     </center>
  {/if}
