{appJsLoad modname='kernel' scriptname='tinymce'} 
<form action="/admin/cities/update" method="post" class="form-horizontal" enctype="multipart/form-data">
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
                            <input type="text" name='name_ru' class="form-control" value='{$city.name_ru}'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#sys_title#} EN</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='name_en' class="form-control" value='{$city.name_en}'>
                        </div>
                    </div>
       
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_code#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='code' class="form-control" value='{$city.code}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_country#}</label>
                        <div class="controls col-sm-11">
                            <select name="country_id" class="form-control selectpicker" data-live-search="true">
                                {html_options options=$countries selected=$city.country_id}
                            </select>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_areaInSqKm#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='areaInSqKm' class="form-control" value='{$city.areaInSqKm}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_population#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='population' class="form-control" value='{$city.population}'>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_description#} RU: </label>
                        <div class="controls col-sm-12">
                            {texteditor name=description_ru text=$city.description_ru}
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_description#} EN: </label>
                        <div class="controls col-sm-12">
                            {texteditor name=description_en text=$city.description_en}
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_north#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='north' class="form-control" value='{$city.north}'>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_south#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='south' class="form-control" value='{$city.south}'>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_east#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='east' class="form-control" value='{$city.east}'>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#cities_west#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='west' class="form-control" value='{$city.west}'>
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