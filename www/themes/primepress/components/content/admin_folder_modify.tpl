{strip}
  <form name="folder_modify_form" action="{mod_url type='admin' modname='content' func='folder_update'}" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="{$id}">
  <input type="hidden" name="http_referer" value="{$http_referer}">
    <table class="outer" cellSpacing="1" cellPadding="4">

        <tr>
          <th>{#editingfolder#}</th>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#folder#}

            {* Формируем плоский масив для вункции html_options *}
              {array name='flat_folderslist'}
              {array_append name='flat_folderslist' key='0' value=#root#}

              {foreach item=folder from=$folders_list}
                {array_append name='flat_folderslist' key=$folder.id value=$folder.displayname|tree:$folder.level}
              {/foreach}

        <br><select name=parent_id>
          {html_options options=$flat_folderslist selected=$parent_id}
        </select>

    </td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#folderdisplayname#}<br><input maxLength="255" size="50" name="displayname" value="{$displayname|escape}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">Имя раздела на англ.<br><input maxLength="255" size="50" name="name" value="{$name|escape}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#description#}<br><textarea name="description" rows="5" cols="60">{$description|escape}</textarea></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#content#}<br>
	{if ($editor==2) or (!$editor)}
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
<select name="editor" onChange="window.location='/index.php?module=content&type=admin&func=folder_modify&id={$id}&editor='+this.value">
<option value="2" {if ($editor==2) or (!$editor)}selected{/if}>TinyMCE</option>
<option value="1" {if $editor==1}selected{/if}>нет</option>
</select>
</td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#logo#}<br>
            <input maxLength="60" size="50" name="logo" value="{$logo}">&nbsp;
            {imagebrowse action="document.folder_modify_form.logo.value"}
          </td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">Шапка<br>
            <input name="header" type="file">
          </td>
        </tr>

        {array name='yes_no'}
        {array_append name='yes_no' key='1' value=#yes#}
        {array_append name='yes_no' key='0' value=#no#}

        <tr vAlign="top" align="left">
          <td class="head">{#active#}<br>
            {html_radios name="active" options=$yes_no checked=$active separator=" "}
          </td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#need_admin_active#}<br>
            {html_radios name="need_admin_active" options=$yes_no checked=$need_admin_active separator=" "}
          </td>
        </tr>

        {array name='asc_yes_no'}
        {array_append name='asc_yes_no' key='1' value=#asc#}
        {array_append name='asc_yes_no' key='0' value=#desc#}

        <tr vAlign="top" align="left">
          <td class="head">{#subfolder_orderby#}<br>
            <select name=subfolder_orderby>
            {html_options options=$folder_orderslist selected=$subfolder_orderby}
            </select>
            {html_radios name="subfolder_order_asc" options=$asc_yes_no checked=$subfolder_order_asc separator=" "}
          </td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#subdoc_orderby#}<br>
            <select name=subdoc_orderby>
            {html_options options=$doc_orderslist selected=$subdoc_orderby}
            </select>
            {html_radios name="subdoc_order_asc" options=$asc_yes_no checked=$subdoc_order_asc separator=" "}
    </td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#subdoc_perpage_admin#}<br><input maxLength="8" size="10" name="subdoc_perpage_admin" value="{$subdoc_perpage_admin}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#subdoc_perpage_user#}<br><input maxLength="8" size="10" name="subdoc_perpage_user" value="{$subdoc_perpage_user}"></td>
        </tr>


        <tr vAlign="top" align="left">
          <td class="head">{#limit_doc_olderdays#}<br><input maxLength="8" size="10" name="limit_doc_olderdays" value="{$limit_doc_olderdays}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#limit_doc_perfolder#}<br><input maxLength="8" size="10" name="limit_doc_perfolder" value="{$limit_doc_perfolder}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="foot" align="center">
            <input class="formButton" type="submit" value="{#edit#}" name="submit">
          </td>
        </tr>

    </table>
  </form>
{/strip}