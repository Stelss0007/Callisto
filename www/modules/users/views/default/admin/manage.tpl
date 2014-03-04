{array name='yes_no'}
{array_append name='yes_no' key='1' value=Да}
{array_append name='yes_no' key='0' value=Нет}

<form action="" method="post" class="form-horizontal">
  <input type="hidden" name='id' value="{$id}">
  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i> {#user_edit#}</h2>
        <div class="box-icon">
          <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
          <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
          <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
      </div>
      <div class="box-content">

          <fieldset>
           {* <legend>Manage form</legend>*}
            <br><br>
            <div class="control-group">
              <label class="control-label" for="date01">{#user_login#}</label>
              <div class="controls">
                <input type="text" name='login' size='40' value='{$login}'>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="date01">{#user_pass#}</label>
              <div class="controls">
                <input type="password" name='pass' size='40' value=''>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="date01">{#user_group#}</label>
              <div class="controls">
                {html_options name=gid options=$groups_list selected=$gid}
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="date01">{#user_email#}</label>
              <div class="controls">
                <input type="text" name='mail' size='40' value='{$mail}'>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="date01">{#user_fio#}</label>
              <div class="controls">
                <input type="text" name='displayname' size='40' value='{$displayname}'>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="date01">{#user_active#}</label>
              <div class="controls">
                {html_radios name=active options=$yes_no checked=$active separator=" "}
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="fileInput">File input</label>
              <div class="controls">
                <input class="input-file uniform_on" id="fileInput" type="file">
              </div>
            </div>          

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">{#sys_save#}</button>
              <button type="reset" class="btn">Cancel</button>
            </div>
          </fieldset>
 

      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>