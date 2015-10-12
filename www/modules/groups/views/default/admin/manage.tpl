       
<form action="/admin/groups/manage" method="post" class="form-horizontal">
  <input type="hidden" name='id' value="{$group->id}">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-users"></i>  {#groups_edit#}</h2>
        <div class="box-icon">
        </div>
      </div>
      <div class="box-content">
        
        <fieldset>
           {* <legend>Manage form</legend>*}
            <br><br>
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#groups_title#}</label>
              <div class="controls col-sm-5">
                <input type="text" name='group_displayname' class="form-control" value='{$group->group_displayname}' style="width: 98%;">
              </div>
             </div>
              
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#groups_description#}</label>
              <div class="controls col-sm-5">
                <textarea name='group_description' class="form-control" style="width: 98%;">{$group->group_description}</textarea>
              </div>
             </div>
              
            <div class="form-actions col-sm-8">
              <button type="submit" class="btn btn-primary" name="submit" value="submit">{#groups_save#}</button>
              <button type="reset" class="btn">Cancel</button>
            </div>
        
        </fieldset>
      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>