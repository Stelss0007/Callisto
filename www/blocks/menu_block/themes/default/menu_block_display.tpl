{strip}
  {foreach item=item from=$items_list}
    {* ��������� ����� ���������� ��� ���� *}
    {array name='url_vars'}
    {array_append name='url_vars' key='id' value=$item.id}    

    {* � ����������� �� ���� ���������� �������� *}

    {if $item.item_type==1}            {* 1 = ����������� *}

    {elseif $item.item_type==2}        {* 2 = ��������� *}

      <b>{$item.displayname|escape|tree:$item.level:'&nbsp;<img src="/public/images/system/right.gif" width="8"  border=0 alt="">':'':'&nbsp;&nbsp;'}</b>

    {elseif $item.item_type==3}        {* 3 = Url *}
      {if $item.id == $cur_item_id}
        {* ������� ������� *}
        <b class="usermnuline-act">{$item.displayname|escape|tree:$item.level:'&nbsp;<img src="/public/images/system/right.gif" width="8"  border=0 alt="">':'':'&nbsp;&nbsp;'}</b>
      {else}
        <a class="usermnuline" href="{$item.content}">{$item.displayname|escape|tree:$item.level:'&nbsp;<img src="/public/images/system/right.gif" width="8"  border=0 alt="">':'':'&nbsp;&nbsp;'}</a>
      {/if}

    {elseif $item.item_type==4}        {* 4 = Html *}

      {$item.content}

    {/if}

  {/foreach}

{/strip}
