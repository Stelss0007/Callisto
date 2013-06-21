{strip}
{* ��������� �������� �������� *}
{counter start=0 print=false}

{* ������ ������ � ����������� �� ��������� � ���� ����������*}

{if $blockinfo.block_position=='c' or $blockinfo.block_position=='t' or $blockinfo.block_position=='b'}
  {* ��� ���� �� ������, ������� ������� �������� ���������� *}
    <table cellSpacing="1" cellPadding="4" width="100%">
      {foreach item=doc from=$docs_list}
        <tr>
          <td class="even">
            {* ��������� ����� ���������� ��� ���� *}
            {array name='url_vars'}
            {array_append name='url_vars' key='id' value=$doc.id}
            {array_append name='url_vars' key='fid' value=$doc.fid}
            <b><a href="{mod_url type='user' modname='content' func='doc_view' vars=$url_vars}">{$doc.displayname|escape}</a></b>
          </td>
        </tr>

        {if $doc.description}
          <tr>
            <td class="odd">
              {if $doc.logo}
                <a href="{mod_url type='user' modname='content' func='doc_view' vars=$url_vars}"><IMG width=90 hspace=5 src="{$doc.logo}" align="left" border="0" alt="{$doc.displayname|escape}"></a>
              {/if}
              <p align="justify">{$doc.description|escape|nl2br|truncate:512}</p>
            </td>
          </tr>
        {/if}

        <tr>
          <td align="right" class="odd">
          .:&nbsp;
            ���� ����������: {$doc.pub_datetime|date_format:"%d.%m.%Y %H:%M"}&nbsp;::

          {* ������� ��� ������ ��� email ��� url *}
          {if $doc.author}
            {if $doc.author_email}
              &nbsp;�������: {mailto address=$doc.author_email text=$doc.author}&nbsp;::
            {elseif $doc.url}
              &nbsp;�������: <a href="{$doc.url}">{$doc.author|escape}</a>&nbsp;::
            {else}
              &nbsp;�������: {$doc.author|escape}&nbsp;::
            {/if}

          {else}
            {if $doc.author_email}
              &nbsp;�������: {mailto address=$doc.author_email}&nbsp;::
            {/if}
          {/if}
          &nbsp;����������: {$doc.counter}&nbsp;:.
          </td>
        </tr>
      {/foreach}
    </table>
    
{else}
  {* ���� ����� �� ������� ������� ���������� *}
  <table border="0" cellSpacing="0" cellPadding="0" width="100%">

    {section name=docs_loop loop=$docs_list}
      <tr>
        <td>
          {* ��������� ����� ���������� ��� ���� *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$docs_list[docs_loop].id}
          {array_append name='url_vars' key='fid' value=$docs_list[docs_loop].fid}
          <a href="{mod_url type='user' modname='content' func='doc_view' vars=$url_vars}" title="{$docs_list[docs_loop].description|escape}">{$docs_list[docs_loop].displayname|escape}</a>
          {* ���-�� ����� � ����������� �� ���� ���������� ���������� �������������� ���������� *}

          {if $doc_orderby=='counter'}
            &nbsp;({$docs_list[docs_loop].counter})
          {/if}

          {if $doc_orderby=='pub_datetime'}
            &nbsp;({$docs_list[docs_loop].pub_datetime|date_format:"%d.%m.%y"})
          {/if}


          {if $smarty.section.docs_loop.iteration!=$smarty.section.docs_loop.total}
            {* ����� ������ �������� ������� �� ������ ���� �������� �� ���������*}
            <br>
            <br>
          {/if}

        </td>
      </tr>
    {/section}
    
  </table>
  
{/if}
{/strip}