{appJsLoad modname='kernel' scriptname='tinymce'} 
<form action="/admin/countries/update" method="post" class="form-horizontal" enctype="multipart/form-data">
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
                            <input type="text" name='name_ru' class="form-control" value='{$country.name_ru}'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#sys_title#} EN</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='name_en' class="form-control" value='{$country.name_en}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_capital#} RU</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='capital_ru' class="form-control" value='{$country.capital_ru}'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_capital#} EN</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='capital_en' class="form-control" value='{$country.capital_en}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_code#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='code' class="form-control" value='{$country.code}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_currency_code#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='currency_code' class="form-control" value='{$country.currency_code}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_continent#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='continent' class="form-control" value='{$country.continent}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_iso_numeric#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='iso_numeric' class="form-control" value='{$country.iso_numeric}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_geonameId#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='geonameId' class="form-control" value='{$country.geonameId}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_areaInSqKm#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='areaInSqKm' class="form-control" value='{$country.areaInSqKm}'>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_population#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='population' class="form-control" value='{$country.population}'>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_description#} RU: </label>
                        <div class="controls col-sm-12">
                            {texteditor name=description_ru text=$country.description_ru}
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_description#} EN: </label>
                        <div class="controls col-sm-12">
                            {texteditor name=description_en text=$country.description_en}
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_north#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='north' class="form-control" value='{$country.north}'>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_south#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='south' class="form-control" value='{$country.south}'>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_east#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='east' class="form-control" value='{$country.east}'>
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#countries_west#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='west' class="form-control" value='{$country.west}'>
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