{strip}
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="2*">
      <col width="*">
      <col width="*">
      <col width="*">
      <col width="*">
      <col width="5%">
    </colgroup>

    <thead>
      <tr>
        <th colSpan="7">������������</th>
      </tr>
      <tr class="head">
        <th>�����</th>
        <th>���� ����������</th>
        <th>������</th>
        <th>������������ ���</th>
        <th>�����</th>
        <th>�������</th>
        <th>��������� �����</th>
        <th></th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <td width="100%" align="center" colspan="7" class="foot">
          <a href="/index.php?module=user&type=admin&func=user_new">��������</a>
        </td>
      </tr>
    </tfoot>

    <tbody>
      {foreach item=user from=$user_list}
      {cycle name="grls" values="even,odd" assign="class" print=false}
        <tr>
          <td class="{$class}" nowrap>{$user.login|escape}</td>
          <td class="{$class}"><font title="{$user.addtime|date_format:"%H:%M"}">{$user.addtime|date_format:"%d.%m.%Y"}</font></td>
          <td class="{$class}">{$group_list[$user.gid]}</td>
          <td class="{$class}">{$user.displayname|escape}</td>
          <td class="{$class}">{$user.mail|escape}</td>
          <td class="{$class}">{if $user.active}Yes{else}No{/if}</td>
          <td class="{$class}">{$user.last_visit|date_format:"%d.%m.%Y %H:%M"}</td>
          <td class="{$class}" align="center" nowrap>
            {* ��������� ����� ���������� ��� ���� *}
            {array name='url_vars'}
            {array_append name='url_vars' key='id' value=$user.id}
              <a href="/index.php?module=user&type=admin&func=user_modify&id={$user.id}"><img border="0" src="/files/shared/images/system/edit.gif" alt="�������������"></a>&nbsp;
              <a href="/index.php?module=user&type=admin&func=user_delete&id={$user.id}"><img border="0" src="/files/shared/images/system/del.gif" alt="�������"></a>
          </td>
        </tr>
      {/foreach}
    </tbody>

  </table>
{/strip}