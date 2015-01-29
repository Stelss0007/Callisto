{strip}
<form action="/admin/blocks/update" method="post" class="form-horizontal">
<input type="hidden" name="id" value="{$id}">
<input type="hidden" name="ref" value="{$ref}">

<div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i>  Редактирование блока "{$block_name}"</h2>
        <div class="box-icon">
        </div>
      </div>
      <div class="box-content">
        
        <fieldset>
           {* <legend>Manage form</legend>*}
            <br><br>
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Название :</label>
              <div class="controls col-sm-5">
                <input type="text" name="block_css_class" class="form-control" disabled="disabled" size="50" value="{$block_name|escape}">
              </div>
             </div>
              
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">ID:</label>
              <div class="controls col-sm-5">
                <input type="text" name="block_css_class" class="form-control" disabled="disabled" size="50" value="{$id}">
              </div>
             </div>
             
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Отображаемое название:</label>
              <div class="controls col-sm-5">
                <input type="text" name="block_displayname" class="form-control" size="50" value="{$block_displayname|escape}">
              </div>
             </div>
              
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Активирован:</label>
              <div class="controls col-sm-5">
                <input data-no-uniform="true" type="checkbox" name="block_active" {if $block_active}checked="checked"{/if} value="1" class="iphone-toggle">
              </div>
             </div>
          
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Маска:</label>
              <div class="controls col-sm-5">
               <input type="text" name="block_pattern" class="form-control" size="50" value="{$block_pattern|escape}">
              </div>
             </div>
             
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Положение:</label>
              <div class="controls col-sm-5">
                <select name='block_position' class="form-control">
                  {html_options options=$positions selected=$block_position}
                </select>
              </div>
             </div>
             
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">CSS класс:</label>
              <div class="controls col-sm-5">
                <input type="text" name="block_css_class" class="form-control" size="50" value="{$block_css_class|escape}">
              </div>
             </div>
              
            {$block_config_result}
             
            <div class="form-actions col-sm-8">
              <button type="submit" class="btn btn-primary" name="submit" value="submit">{#sys_save#}</button>
              &nbsp;
              <button type="submit" class="btn btn-primary" name="submit_exit" value="submit_exit">{#sys_save_exit#}</button>
              &nbsp;
              <button type="reset" class="btn">Cancel</button>
            </div>
        
        </fieldset>
      </div>
    </div><!--/span-->

  </div><!--/row-->
  

</form>
{/strip}