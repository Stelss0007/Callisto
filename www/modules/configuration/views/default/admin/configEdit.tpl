<form class="form-horizontal" method="post" action="/admin/configuration/save">
  <div class="row-fluid">
    <div class="box span12">
      <div data-original-title="" class="box-header well">
        <h2><i class="icon-cog"></i>  
          {if $module_name == 'main'}
            {#main_config#}
          {else}
            {#sys_configuration_module#} '{$module_name}'
          {/if}
        </h2>
        <div class="box-icon">
        </div>
      </div>
      <div class="box-content">

        <fieldset>
          {$config_body}

          <div class="form-actions">
            <button value="submit" name="submit" class="btn btn-primary" type="submit">{#sys_save#}</button>
            <button class="btn" type="reset">{#sys_cancel#}</button>
          </div>

        </fieldset>
      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>
