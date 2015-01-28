   
<form action="" method="post" class="form-horizontal">
  <input type="hidden" name='id' value="{$id}">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-eye-open"></i>  Редактирование прав доступа</h2>
      </div>
      <div class="box-content">
        
        <fieldset>
           {* <legend>Manage form</legend>*}
            <br><br>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Группа</label>
              <div class="controls col-sm-5">
                {html_options name=group_permission_gid options=$groups selected=$group_permission_gid class="form-control"}
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Объект</label>
              <div class="controls col-sm-5">
                 <input type="text" name='group_permission_pattern' value='{$group_permission_pattern}' class="form-control"  style="">
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Уровень доступа</label>
              <div class="controls col-sm-5">
                {html_options name=group_permission_level options=$levels selected=$group_permission_level class="form-control"}
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Описание</label>
              <div class="controls col-sm-5">
                <textarea name='group_permission_description' style="" class="form-control">{$group_permission_description}</textarea>
              </div>
            </div>
              
            <div class="form-actions col-sm-8">
              <button type="submit" class="btn btn-primary" name="submit" value="true">{#sys_save#}</button>
              <button type="reset" class="btn">Cancel</button>
            </div>
            
        </fieldset>
      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>      