<div class="row-fluid sortable">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list"></i> {#menu_header#}</h2>
      <div class="box-icon">
        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">

      <table width='100%' cellspacing=0 cellpadding=4 class="table table-striped table-bordered bootstrap-datatable">
        <colgroup>
          <col width='340'>
          <col width='*'>
          <col width='95'>
          <col width='100'>
        </colgroup>
        <thead>
          <tr>
            <th>
              {#menu_title#}
            </th>
            <th>
              {#menu_url#}
            </th>
            <th>
              {#menu_order#}
            </th>
            <th>
              {#menu_actions#}
            </th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$menus item=menu name=menu_}
            {cycle name="menu" values="even,odd" assign="class" print=false}
            <tr class='{$class}'>
              <td>
                <a href="/admin/menu/menu_list/{$menu.id}">{$menu.menu_title}{if $menu.menu_subitem_counter > 0}&nbsp;({$menu.menu_subitem_counter}){/if}</a>
              </td>

              <td>
                <a href="{$menu.menu_content}">{$menu.menu_content}</a>
              </td>
              <td style="text-align: center;">
                <div class="btn-group">
                  {if !$smarty.foreach.menu_.first}
                    <a href="/admin/menu/weight_up/{$menu.menu_weight}/{$menu.menu_parent_id}" class="btn btn-icon btn-up" title="{#sys_up#}"><i class="icon-arrow-up"></i></a>
                  {/if}
                  {if !$smarty.foreach.menu_.first && !$smarty.foreach.menu_.last}

                  {/if}
                  {if !$smarty.foreach.menu_.last}
                    <a href="/admin/menu/weight_down/{$menu.menu_weight}/{$menu.menu_parent_id}" class="btn btn-icon btn-down" title="{#sys_down#}"><i class="icon-arrow-down"></i></a>
                  {/if}
                </div>
              </td>
              <td>
                <div class="btn-group">
                  <a href='/admin/menu/modify/{$menu.id}' title="{#sys_edit#}" class="btn btn-icon btn-edit"><i class="icon-edit"></i></a>
                  <a href='/admin/menu/delete/{$menu.id}' title="{#sys_delete#}" class="btn btn-icon btn-delete" onclick="return confirm('{#sys_confirm_delete#}');"><i class="icon-trash"></i></a>
                </div>
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
      <div style="text-align: center;">
        <a href='/admin/menu/create{if $parent_id}/{$parent_id}{/if}' class='btn'><i class="icon icon-add"></i> {#menu_add#}</a>
      </div>

    </div>
  </div><!--/span-->

</div><!--/row-->