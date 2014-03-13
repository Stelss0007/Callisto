{appJsLoad modname='kernel' scriptname='tinymce'}    
<form action="/admin/groups/manage" method="post" class="">
  <input type="hidden" name='id' value="{$id}">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i>  �������� ������</h2>
        <div class="box-icon">
        </div>
      </div>
      <div class="box-content">

        <fieldset>
          {* <legend>Manage form</legend>*}

          <div class="control-group">
            <span class="control-label">{#sys_title#}</span>
            <div class="controls">
              <input type="text" name='group_displayname' value='{$group_displayname}' style="width: 98%;">
            </div>
          </div>

          <div class="box-content">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#info">������</a></li>
              <li><a href="#custom">��������� ����������</a></li>
              <li><a href="#messages">SEO</a></li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div id="info" class="tab-pane active row-fluid">
                <div class="span10">
                  {texteditor}
                </div>

                <div class="span2 form-vertical">
                  <div class="control-group">
                    <label class="control-label" for="date01">���������:</label>
                    <div class="controls">
                      <select name=menu_type class="chzn-done" data-rel="chosen">

                      </select>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="date01">���������: </label>
                    <div class="controls">
                      <input data-no-uniform="true" type="checkbox" name="article_active" checked="checked" class="iphone-toggle">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="date01">�����: </label>
                    <div class="controls">
                      <select id="selectError1" multiple data-rel="chosen">
                        <option>Option 1</option>
                        <option selected>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                        <option>Option 5</option>
                      </select>
                    </div>
                  </div>
                  
                </div>
              </div>
                
              <div id="custom" class="tab-pane form-horizontal">
                <div class="control-group">
                  <label class="control-label" for="date01">������ ����������: </label>
                  <div class="controls">
                    <input class="span2 datepicker" maxlength="45" size="42" type="text" value="12-02-2012" data-date-format="mm-dd-yyyy">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="date01">��������� ����������: </label>
                  <div class="controls">
                    <input class="span2 datepicker" size="16" type="text" value="12-02-2012">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="date01">���� ��������: </label>
                  <div class="controls">
                    <input class="span2 datepicker" size="16" type="text" value="12-02-2012">
                  </div>
                </div>
              </div>
                
              <div id="messages" class="tab-pane">
                <div class="control-group">
                  <label class="control-label" for="date01">����-��� Description: </label>
                  <div class="controls">
                    <textarea cols="700" rows="5" style="width: 700px;"></textarea>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="date01">����-��� Keywords: </label>
                  <div class="controls">
                    <textarea cols="70" rows="5" style="width: 700px;"></textarea>
                  </div>
                </div>
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