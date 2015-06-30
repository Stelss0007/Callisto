{appJsLoad modname='kernel' scriptname='tinymce'} 
<form action="/admin/places/update" method="post" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name='id' value="{$id}">
    <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i> {if $id}{#sys_edit#}{else}{#sys_add#}{/if}</h2>
                <div class="box-icon">
                </div>
            </div>
            <div class="box-content">
                    <br>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#sys_title#} RU</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='name_ru' class="form-control" value='{$place.name_ru}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#sys_title#} EN</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='name_en' class="form-control" value='{$place.name_en}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#places_country#}</label>
                        <div class="controls col-sm-11">
                            <select name="country_id" class="form-control selectpicker" data-live-search="true">
                                {html_options options=$countries selected=$place.country_id}
                            </select>
                        </div>
                    </div>
                        
                  
                    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#places_description#} RU: </label>
                        <div class="controls col-sm-12">
                            {texteditor name=description_ru text=$place.description_ru}
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#places_description#} EN: </label>
                        <div class="controls col-sm-12">
                            {texteditor name=description_en text=$place.description_en}
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#places_lat#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='lat' class="form-control" value='{$place.lat}'>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#places_lng#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='lng' class="form-control" value='{$place.lng}'>
                        </div>
                    </div>    
                        

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="submit" value="submit">{#sys_save#}</button>
                        <button type="reset" class="btn">{#sys_cancel#}</button>
                    </div>
            </div>
        </div><!--/span-->

    </div><!--/row-->
</form>