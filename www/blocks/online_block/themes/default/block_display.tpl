{strip}
  Сейчас, {$num_guests}&nbsp;гостей и<br>{$num_users}&nbsp;посетитель онлайн.<br>
  {if $user_vars}
  Вы зашли как<br>
    {* Если неуказан дисплей наме выводим наме *}
    {if $user_vars.user_displayname}
      <b>{$user_vars.user_displayname|escape}</b>.
    {else}
      <b>{$user_vars.user_name|escape}</b>.
    {/if}
  {else}
  Вы анонимный пользователь.
  {/if}
<br>
{/strip}
