{strip}

        <tr vAlign="top" align="left">
          <td class="head">Документы из раздела</td>
          <td class="even">

            {* Формируем плоский масив для вункции html_options *}
      {array name='flat_folderslist'}
      {array_append name='flat_folderslist' key='-1' value='Текущий'}
      {array_append name='flat_folderslist' key='0' value='Корень'}

      {foreach item=folder from=$folders_list}
      {array_append name='flat_folderslist' key=$folder.id value=$folder.displayname|escape|tree:$folder.level}
            {/foreach}

      <select name=folder_id>
      {html_options options=$flat_folderslist selected=$folder_id}
      </select>
  &nbsp;(Текущий - отображает документы текущего раздела, только если блок размешен в content)

    </td>
        </tr>



        {array name='yes_no'}
        {array_append name='yes_no' key='1' value='Да'}
        {array_append name='yes_no' key='0' value='Нет'}
        <tr vAlign="top" align="left">
          <td class="head">Включая подразделы</td>
          <td class="even">
            {html_radios name="include_subfolders" options=$yes_no checked=$include_subfolders separator="&nbsp;"}
    </td>
        </tr>



        {array name='asc_yes_no'}
        {array_append name='asc_yes_no' key='1' value='По возрастанию'}
        {array_append name='asc_yes_no' key='0' value='По убыванию'}
        <tr vAlign="top" align="left">
          <td class="head">Сортировать документы по :</td>
          <td class="even">
            <select name=doc_orderby>
            {html_options options=$doc_orders_list selected=$doc_orderby}
            </select>
            {html_radios name="doc_order_asc" options=$asc_yes_no checked=$doc_order_asc separator="&nbsp;"}
    </td>
        </tr>


        <tr vAlign="top" align="left">
          <td class="head">Число выводимых документов</td>
          <td class="even"><input maxLength="10" size="10" name="doc_count" value="{$doc_count}"></td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">Время обновления блока в минутах</td>
          <td class="even"><input maxLength="10" size="10" name="block_ttl" value="{$block_ttl}"></td>
        </tr>

{/strip}