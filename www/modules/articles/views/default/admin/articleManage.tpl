{appJsLoad modname='kernel' scriptname='tinymce'}    
<form action="/admin/groups/manage" method="post" class="form-horizontal">
  <input type="hidden" name='id' value="{$id}">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i>  Менеджер статей</h2>
        <div class="box-icon">
        </div>
      </div>
      <div class="box-content">
        
        <fieldset>
           {* <legend>Manage form</legend>*}

             <div class="control-group">
              <label class="control-label" for="date01">{#sys_title#}</label>
              <div class="controls">
                <input type="text" name='group_displayname' value='{$group_displayname}' style="width: 98%;">
              </div>
             </div>
              
             <div class="box-content">
                <ul id="myTab" class="nav nav-tabs">
                  <li class="active"><a href="#info">Статья</a></li>
                  <li><a href="#custom">Параметры публикации</a></li>
                  <li><a href="#messages">SEO</a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                  <div id="info" class="tab-pane active row-fluid">
                    <div class="span10">
                      {texteditor}
                    </div>
                    <div class="span2">
                      test
                    </div>
                  </div>
                  <div id="custom" class="tab-pane">
                    <h3>Custom <small>small text</small></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at. Nulla tellus elit, varius non commodo eget, mattis vel eros. In sed ornare nulla. Donec consectetur, velit a pharetra ultricies, diam lorem lacinia risus, ac commodo orci erat eu massa. Sed sit amet nulla ipsum. Donec felis mauris, vulputate sed tempor at, aliquam a ligula. Pellentesque non pulvinar nisi.</p>
                  </div>
                  <div id="messages" class="tab-pane">
                    <h3>Messages <small>small text</small></h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at. Nulla tellus elit, varius non commodo eget, mattis vel eros. In sed ornare nulla. Donec consectetur, velit a pharetra ultricies, diam lorem lacinia risus, ac commodo orci erat eu massa. Sed sit amet nulla ipsum. Donec felis mauris, vulputate sed tempor at, aliquam a ligula. Pellentesque non pulvinar nisi.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor.</p>
                  </div>
                </div>
              </div> 
              
            <div class="form-actions">
              <button type="submit" class="btn btn-primary" name="submit" value="submit">{#sys_save#}</button>
              <button type="reset" class="btn">Cancel</button>
            </div>
        
        </fieldset>
      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>