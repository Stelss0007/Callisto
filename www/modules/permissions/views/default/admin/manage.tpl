   
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
            <div class="control-group">
              <label class="control-label" for="date01">Группа</label>
              <div class="controls">
                {html_options name=gid options=$groups selected=$group_permission_gid}
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="date01">Объект</label>
              <div class="controls">
                 <input type="text" name='pattern' value='{$group_permission_pattern}'  style="width: 98%;">
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="date01">Уровень доступа</label>
              <div class="controls">
                {html_options name=level options=$levels selected=$group_permission_level}
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="date01">Описание</label>
              <div class="controls">
                <textarea name='description' style="width: 98%;">{$group_permission_description}</textarea>
              </div>
            </div>
              
            <div class="form-actions">
              <button type="submit" class="btn btn-primary" name="submit" value="true">{#sys_save#}</button>
              <button type="reset" class="btn">Cancel</button>
            </div>
            
        </fieldset>
      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>      