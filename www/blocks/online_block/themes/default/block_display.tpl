{strip}
  ������, {$num_guests}&nbsp;������ �<br>{$num_users}&nbsp;���������� ������.<br>
  {if $user_vars}
  �� ����� ���<br>
    {* ���� �������� ������� ���� ������� ���� *}
    {if $user_vars.user_displayname}
      <b>{$user_vars.user_displayname|escape}</b>.
    {else}
      <b>{$user_vars.user_name|escape}</b>.
    {/if}
  {else}
  �� ��������� ������������.
  {/if}
<br>
{/strip}
