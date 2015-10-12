<div class="row-fluid">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> Members</h2>
    </div>
    <div class="box-content">

      <form action="/admin/users/group_operation">
        <div class="btn-toolbar batch-actions-buttons">
          <div class="btn-group">
            <a href='/admin/users/manage' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
            <a href='/admin/configuration/users' class="btn btn-default" title="{#sys_configuration#}"><i class="icon-cog"></i> {#sys_configuration#}</a>
            <a href='#' rel="activate" class="btn btn-default" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
            <a href='#' rel="deactivate" class="btn btn-default" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
          </div>

          <div class="btn-group delete-group">
            <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
          </div>
        </div>

        <table  width='100%' cellspacing=0 cellpadding=2 class="table table-striped table-bordered bootstrap-datatable">
          <thead style="">
            <tr>
              <th style="width: 25px;">
                <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
              </th>
              <th>
                ID
              </th>
              <th>
                Логин
              </th>
              <th>
                Имя(Ф.И.О)
              </th>
              <th>
                E-mail
              </th>
              <th>
                Группа
              </th>
              <th>
                Дата Регистрации
              </th>
              <th>
                Последний вход в стистему
              </th>
              <th style="width: 110px;">
                Действия
              </th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$users_list item=user}
              {cycle name="users" values="even,odd" assign="class" print=false}
              <tr class='{$class}'>
                <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$user->id}">
                </th>
                <td>
                  {$user->id}
                </td>

                <td>
                  {$user->login}
                </td>

                <td>
                  {$user->displayname}
                </td>

                <td>
                  {$user->mail}
                </td>

                <td>
                  {$groups_list[$user->gid]}
                </td>

                <td>
                  {$user->addtime|date_format:'%d.%m.%Y'}
                </td>

                <td>
                  {$user->last_visit|date_format:'%d.%m.%Y %H:%M'}
                </td>

                <td>
                  <div class="btn-group">
                    {if $user->active}
                      <a href='/admin/users/activation/{$user->id}' onclick="return confirm('{#user_disabled#}?')" title='{#user_disabled#}' class="btn btn-icon btn-pause"><i class="icon-pause"></i></a>
                      {else}
                      <a href='/admin/users/activation/{$user->id}' onclick="return confirm('{#user_enabled#}?')" title='{#user_enabled#}' class="btn btn-icon btn-play"><i class="icon-play"></i></a>
                      {/if}
                    <a href='/admin/users/manage/{$user->id}' title='{#user_edit#}' class=" btn btn-icon btn-edit"><i class="icon-edit"></i></a>
                    <a href='/admin/users/delete/{$user->id}' title='{#user_delete#}' class="btn btn-icon btn-delete"><i class="icon-trash"></i></a>
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