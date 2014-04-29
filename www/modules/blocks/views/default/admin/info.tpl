<div class="form-horizontal">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i>  Информация о блоке</h2>
        <div class="box-icon">
        </div>
      </div>
      <div class="box-content">

        <fieldset>
          {foreach item=value key=key from=$block_info name=block_inf}
            <div class="control-group">
              <label class="control-label" for="date01">{$key}:</label>
              <div class="controls">
                <input type="text" name="block_css_class" disabled="disabled" size="50" value="{$value|escape}">
              </div>
            </div>
          {/foreach}
        </fieldset>
      </div>
    </div><!--/span-->

  </div><!--/row-->
</div>