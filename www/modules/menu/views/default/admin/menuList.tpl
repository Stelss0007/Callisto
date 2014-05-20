<div class="row-fluid sortable">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list"></i> {#menu_header#}</h2>
    </div>
    <div class="box-content">

    <form action="/admin/menu/group_operation">
      <div class="btn-toolbar batch-actions-buttons">
        <div class="btn-group">
          <a href='/admin/menu/create{if $parent_id}/{$parent_id}{/if}' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
          <a href='/admin/menu/config' class="btn btn-icon btn-star-o" title="{#sys_configuration#}"><i class="icon-wrench"></i> {#sys_configuration#}</a>
          <a href='#' rel="activate" class="btn btn-icon btn-star-o " title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
          <a href='#' rel="deactivate" class="btn btn-icon btn-star-o " title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
        </div>

        <div class="btn-group delete-group">
          <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
        </div>
      </div>
      <table width='100%' cellspacing=0 cellpadding=4 class="table table-striped table-bordered bootstrap-datatable">
        <colgroup>
          <col width='30'>
          <col width='20'>
          <col width='340'>
          <col width='*'>
          <col width='95'>
          <col width='100'>
        </colgroup>
        <thead>
          <tr>
            <th style="width: 25px;">
                <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
            </th>
            <th>
              ID
            </th>
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
              <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$menu.id}">
              </th>
              <td>
                {$menu.id}
              </td>
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
    </form>
    
    </div>
  </div><!--/span-->

</div><!--/row-->