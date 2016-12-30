{appJsLoad modname='kernel' scriptname='tinymce'}    
<form action="/admin/articles/category_manage" method="post" class="form-horizontal">
  <input type="hidden" name='id' value="{$id}">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i>  Менеджер категорий статей</h2>
      </div>
        
      <div class="box-content">
          {* <legend>Manage form</legend>*}
          <div class="form-group">
            <label class="col-sm-1 control-label">
                {#sys_title#}
            </label>
            <div class="controls col-sm-11">
                <input type="text" name='article_category_title' value='{$article_category_title}' class="form-control">
            </div>
          </div>

          <div class="">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#info" aria-controls="profile" role="tab" data-toggle="tab">Категория</a></li>
              <li><a href="#seo" aria-controls="profile" role="tab" data-toggle="tab">SEO</a></li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div id="info" class="tab-pane active row-fluid">
                <div class="span9" style="position: relative;">
                  {texteditor name=article_category_description text=$article_category_description}
                </div>

                <div class="span2">
                  <div class="control-group">
                    <label class="control-label" for="date01">Состояние: </label>
                    <div class="controls">
                      <input data-no-uniform="true" type="checkbox" name="article_category_active" {if $article_category_active}checked="checked"{/if} value="1" class="iphone-toggle">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="date01">Метки: </label>
                    <div class="controls">
                      <select name="article_category_tags" multiple data-rel="chosen">
                        {html_options options=$tags selected=$article_category_tags}
                      </select>
                    </div>
                  </div>
                  
                </div>
              </div>
          
              <div id="seo" class="tab-pane row-fluid">
                <div class="control-group">
                  <label class="control-label" for="date01">Мета-тег Description: </label>
                  <div class="controls">
                    <textarea cols="700" rows="5" style="width: 700px;" name="article_category_meta_description">{$article_category_meta_description}</textarea>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="date01">Мета-тег Keywords: </label>
                  <div class="controls">
                    <textarea cols="70" rows="5" style="width: 700px;" name="article_category_meta_keywords">{$article_category_meta_keywords}</textarea>
                  </div>
                </div>
              </div>
                
            </div>
          </div> 

          <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit" value="submit">{#sys_save#}</button>
            <button type="reset" class="btn">Cancel</button>
          </div>
      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>