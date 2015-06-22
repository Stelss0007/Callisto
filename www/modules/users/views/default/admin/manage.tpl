{array name='yes_no'}
{array_append name='yes_no' key='1' value=Да}
{array_append name='yes_no' key='0' value=Нет}

<form action="/admin/users/manage" method="post" class="form-horizontal">
  <input type="hidden" name='id' value="{$id}">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i> {#user_edit#}</h2>
      </div>
      <div class="box-content">

          <fieldset>
           {* <legend>Manage form</legend>*}
            <br><br>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#user_login#}</label>
              <div class="controls col-sm-5">
                <input type="text" name='login' class="form-control" size='40' value='{$login}'>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#user_pass#}</label>
              <div class="controls col-sm-5">
                <input type="password"  name='pass' class="form-control" size='40' value=''>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#user_group#}</label>
              <div class="controls col-sm-5">
                  {html_options name=gid options=$groups_list selected=$gid class='form-control selectpicker'}
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#user_email#}</label>
              <div class="controls col-sm-5">
                <input type="text" name='mail' class="form-control" size='40' value='{$mail}'>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#user_fio#}</label>
              <div class="controls col-sm-5">
                <input type="text" name='displayname' class="form-control" size='40' value='{$displayname}'>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#user_active#}</label>
              <div class="controls col-sm-5">
                {html_radios name=active options=$yes_no checked=$active separator=" "}
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="fileInput">File input</label>
              <div class="controls col-sm-5">
                <input class="input-file uniform_on" id="fileInput" type="file">
              </div>
            </div>          

            <div class="form-actions col-sm-8">
              <button type="submit" class="btn btn-primary" name="submit" value="true">{#sys_save#}</button>
              <button type="reset" class="btn btn-default">Cancel</button>
            </div>
          </fieldset>
 

      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>