<script language="JavaScript" src="/scripts/tigra_calendar/calendar_db.js"></script>
<link rel="stylesheet" href="/scripts/tigra_calendar/calendar.css">
  <form name="doc_new_form" action="{mod_url type='admin' modname='content' func='doc_create'}" method="post" enctype="multipart/form-data">
  <input type="hidden" name="fid" value="{$fid}">
    <table class="outer" cellSpacing="1" cellPadding="4">

        <tr>
          <th>{#addingdoc#}</th>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#folder#}<br>
            {* Формируем плоский масив для вункции html_options *}
            {array name='flat_folderslist'}

            {foreach item=folder from=$folders_list}
            {array_append name='flat_folderslist' key=$folder.id value=$folder.displayname|tree:$folder.level}
            {/foreach}

            <select name="fids[]" size="10" multiple="multiple">
            {html_options options=$flat_folderslist selected=$fid}
            </select>

            </td>
        </tr>


        <tr vAlign="top" align="left">
          <td class="head">{#docdisplayname#}<br><input maxLength="255" size="60" name="displayname" value="{$displayname}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#description#}<br><textarea name="description" rows="5" cols="60">{$description}</textarea></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#content#}<br>{texteditor name="content" text=$content}</td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#logo#}<br><input maxLength="60" size="50" name="logo" value="{$logo}">&nbsp;
            {imagebrowse action="document.doc_new_form.logo.value"}
          </td>
        </tr>
        <tr vAlign="top" align="left">
          <td class="head">Шапка<br>
            <input name="header" type="file">
          </td>
        </tr>
        {usergetvars assign=uservars}

        <tr vAlign="top" align="left">
          <td class="head">{#author#}<br><input maxLength="60" size="50" name="author" value="{$uservars.user_displayname}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#author_email#}<br><input maxLength="60" size="50" name="author_email" value="{$uservars.user_femail}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#author_url#}<br><input maxLength="60" size="50" name="url" value="{$uservars.user_url}"></td>
        </tr>

        {array name='asc_yes_no'}
        {array_append name='asc_yes_no' key='1' value='Да'}
        {array_append name='asc_yes_no' key='0' value='Нет'}

        <tr vAlign="top" align="left">
          <td class="head">{#active#}<br>
            {html_radios name="active" options=$asc_yes_no checked=1 separator=" "}
          </td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">{#pub_datetime#}<br>
       {*   {html_select_date time=$pub_datetime start_year="-1" end_year="+1" field_order=DMY prefix='pub_date_'}&nbsp;*}
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
            <input type="submit" value="Добавить" name="submit">
          </td>
        </tr>

    </table>
  </form>
