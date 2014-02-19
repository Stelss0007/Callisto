<div class="row-fluid sortable">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> Members</h2>
      <div class="box-icon">
        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">

      <table  width='100%' cellspacing=0 cellpadding=2 class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead style="">
          <tr>
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
              <td>
                {$user.id}
              </td>

              <td>
                {$user.login}
              </td>

              <td>
                {$user.displayname}
              </td>

              <td>
                {$user.mail}
              </td>

              <td>
                {$groups_list[$user.gid]}
              </td>

              <td>
                {$user.addtime|date_format:'%d.%m.%Y'}
              </td>

              <td>
                {$user.last_visit|date_format:'%d.%m.%Y %H:%M'}
              </td>

              <td>
                <div class="btn-group">
                  {if $user.active}
                    <a href='/admin/users/activation/{$user.id}' onclick="return confirm('{#user_disabled#}?')" title='{#user_disabled#}' class="btn btn-icon btn-pause"><i class="icon-pause"></i></a>
                  {else}
                    <a href='/admin/users/activation/{$user.id}' onclick="return confirm('{#user_enabled#}?')" title='{#user_enabled#}' class="btn btn-icon btn-play"><i class="icon-play"></i></a>
                  {/if}
                  <a href='/admin/users/manage/{$user.id}' title='{#user_edit#}' class=" btn btn-icon btn-edit"><i class="icon-edit"></i></a>
                  <a href='/admin/users/delete/{$user.id}' title='{#user_delete#}' onclick="return confirm({#user_delete#}?')" class="btn btn-icon btn-delete"><i class="icon-trash"></i></a>
                </div>
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
      <div style="text-align: center;">
        <a href='/admin/users/manage' class='btn'><i class="icon icon-add"></i> Добавить</a>
      </div>

    </div>
  </div><!--/span-->

</div><!--/row-->