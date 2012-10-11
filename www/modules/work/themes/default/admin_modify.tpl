{strip}

{****************************************************************************}
{*                     РЕДАКТИРОВАНИЕ ГРУППЫ                                *}
{****************************************************************************}

<form action="/index.php?module=groups&type=admin&func=update" method="post">
  <input name="id" type="hidden" value="{$id}">
  <input name="ref" type="hidden" value="{$ref}">

  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="80%">
    </colgroup>

    <thead>
      <tr>
        <th colSpan="2">Редактирование группы</th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <td class="foot" colSpan="2" align="center"><input type="submit" value="Сохранить" name="group_submit"></td>
      </tr>
    </tfoot>

    <tbody>
      <tr vAlign="top" align="left">
        <td class="head">Имя группы</td>
        <td class="even">
          <input maxLength="60" size="70" name="group_displayname" value="{$group_displayname|escape}">
        </td>
      </tr>

      <tr vAlign="top" align="left">
        <td class="head">Описание</td>
        <td class="even"><textarea name="group_description" rows="5" cols="70">{$group_description|escape}</textarea></td>
      </tr>
    </tbody>

  </table>
</form>

{****************************************************************************}
{*                        ПРАВА ГРУППЫ                                      *}
{****************************************************************************}

 <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="10%">
      <col width="10%">
      <col width="60%">
      <col width="10%">
      <col width="5%">
      <col width="5%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">Права группы</th>
      </tr>

      <tr align="middle">
        <td class="head">Группа</td>
        <td class="head">Компонент</td>
        <td class="head">Объект</td>
        <td class="head">Уровень прав</td>
        <td class="head">Посл.</td>
        <td class="head">Действия</td>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <td width="100%" align="center" colspan="6" class="foot">
          <a href="/index.php?module=groups&type=admin&func=perms_new&id={$id}">Добавить</a>
        </td>
      </tr>
    </tfoot>

    <tbody>
      {foreach item=groups_perms from=$group_perms_list}
      {cycle name="grprls" values="even,odd" assign="class" print=false}
        <tr>
          <td class="{$class}" align="left">{$groups_perms.gid}</td>
          <td class="{$class}" align="left">{$groups_perms.component}</td>
          <td class="{$class}" align="left">{$groups_perms.pattern}</td>
          <td class="{$class}" align="center">{$perms_level_list[$groups_perms.level]}</td>
          <td class="{$class}" nowrap align="center">
            {if $groups_perms.weight_moveup_url}
              <a href="{$groups_perms.weight_moveup_url}"><img border="0" src="/files/shared/images/system/up.gif"></a>
            {/if}
            {if $groups_perms.weight_moveup_url && $groups_perms.weight_movedown_url}
              &nbsp;
            {/if}
            {if $groups_perms.weight_movedown_url}
              <a href="{$groups_perms.weight_movedown_url}"><img border="0" src="/files/shared/images/system/down.gif"></a>
            {/if}
          </td>
          <td class="{$class}" align="center">
            
            <a href="/index.php?module=groups&type=admin&func=perms_modify&id={$groups_perms.id}"><img border="0" src="/files/shared/images/system/edit.gif" alt="Редактировать"></a>&nbsp;
            <a href="/index.php?module=groups&type=admin&func=perms_delete&id={$groups_perms.id}" onclick="return confirm('Удалить запись?')"><img border="0" src="/files/shared/images/system/del.gif" alt="Удалить"></a>
          </td>
        </tr>
      {/foreach}
    </tbody>
  </table>

{/strip}