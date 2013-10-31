{strip}

  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="70%">
      <col width="10%">
    </colgroup>

    <thead>
      <tr>
        <th colSpan="3">Список групп</th>
      </tr>
      <tr align="middle">
        <td class="head">Имя группы</td>
        <td class="head">Описание</td>
        <td class="head" nowrap>Действия</td>
      </tr>
    </thead>

    {* Список груп в системе *}
    <tbody>
      {foreach item=group from=$groups_list}
      {cycle name="grplist" values="even,odd" assign="class" print=false}
        <tr>
          <td class="{$class}">
            {* Формируем масив переменные для урла *}
            {array name='url_vars'}
            {array_append name='url_vars' key='user_gid' value=$group.id}
            <a href="/index.php?module=user&type=admin&func=user_list&gid={$group.id}">{$group.group_displayname|escape}</a>
          <td class="{$class}">{$group.group_description|escape}</td>
          <td class="{$class}" align="center">
            {* Формируем масив переменные для урла *}
            {array name='url_vars'}
            {array_append name='url_vars' key='user_gid' value=$group.id}
            <a href=""><img border="0" src="/public/images/system/info.gif" alt="Журнал действий"></a>&nbsp;

            {array name='url_vars'}
            {array_append name='url_vars' key='id' value=$group.id}
            <a href="/index.php?module=groups&type=admin&func=modify&id={$group.id}"><img border="0" src="/public/images/system/edit.gif" alt="Редактировать"></a>&nbsp;
            <a href="/index.php?module=groups&type=admin&func=delete&id={$group.id}"><img border="0" src="/public/images/system/del.gif" alt="Удалить"></a>
          </td>
        </tr>
      {/foreach}
    </tbody>
  </table>

  <br>

  <form action="/index.php?module=groups&type=admin&func=create" method="post">
    <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
      <colgroup>
        <col width="20%">
        <col width="80%">
      </colgroup>

      <thead>
        <tr>
          <th colSpan="2">Создать группу<th>
        </tr>
      </thead>

      <tfoot>
        <tr>
          <td class="foot" colspan="2" align="center">
            <input type="submit" value="Создать" name="group_submit">
          </td>
        </tr>
      </tfoot>

      <tbody>
        <tr vAlign="top" align="left">
          <td class="head">Имя группы</td>
          <td class="even">
            <input id="group_displayname" maxLength="60" size="70" name="group_displayname">
          </td>
        </tr>

        <tr vAlign="top" align="left">
          <td class="head">Описание</td>
          <td class="even"><textarea name="group_description" rows="5" cols="70"></textarea></td>
        </tr>
      </tbody>

    </table>

  </form>

{/strip}