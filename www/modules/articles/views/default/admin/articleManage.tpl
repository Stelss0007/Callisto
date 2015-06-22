{appJsLoad modname='kernel' scriptname='tinymce'} 
<form action="/admin/articles/article_manage" method="post" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name='id' value="{$id}">
    <div class="row-fluid">
        <div class="box span12">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i> {if $id}{#articles_edit#}{else}{#articles_add#}{/if}</h2>
                <div class="box-icon">
                </div>
            </div>
            <div class="box-content">

                <fieldset>
                    {* <legend>Manage form</legend>*}
                    <br>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">{#sys_title#}</label>
                        <div class="controls col-sm-11">
                            <input type="text" name='article_title' class="form-control" value='{$article_title}' style="width: 90%;">
                        </div>
                    </div>

                    <div class="box-content">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active">
                                <a href="#info" aria-controls="profile" role="tab" data-toggle="tab">{#articles_article#}</a>
                            </li>
                            <li>
                                <a href="#custom" aria-controls="profile" role="tab" data-toggle="tab">{#articles_public_params#}</a>
                            </li>
                            <li>
                                <a href="#messages" aria-controls="profile" role="tab" data-toggle="tab">{#articles_seo#}</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div id="info" class="tab-pane active row-fluid">
                                <div class="form-group">
                                    <div class="col-sm-12" style="position: relative;">
                                        {texteditor name=article_description text=$article_description}
                                    </div>
                                </div>
                            </div>

                            <div id="custom" class="tab-pane form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="date01">{#articles_category#}:</label>
                                    <div class="controls col-sm-10">
                                        <select name="article_category_id" class="form-control selectpicker">
                                            {html_options options=$article_category_list selected=$article_category_id}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="date01">{#articles_state#}: </label>
                                    <div class="controls col-sm-10">
                                        <div>
                                            <input type="checkbox" name="article_active" {if $article_active}checked="checked"{/if} value="1" class="switch" data-size="mini">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="date01">{#articles_tags#}: </label>
                                    <div class="controls col-sm-10">
                                        <input type="text" class="form-control" name="article_tags" value="{$article_tags}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="fileInput">{#articles_image#}</label>
                                    <div class="controls col-sm-10">
                                        {if $article_image}
                                            <img src="/{$article_image.320}" width="320">
                                        {/if}
                                        <input class="input-file uniform_on" id="fileInput" type="file" name="post_image">
                                    </div>
                                </div>    

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="date01">{#articles_start_publication#}: </label>
                                    <div class="controls col-sm-10">
                                        <div class="input-group input-append">
                                            <input class="datepicker" size="16" type="text" name="article_start_time" value="{$article_start_time|date_format}">
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="date01">{#articles_end_publication#}: </label>
                                    <div class="controls col-sm-10">
                                        <div class="input-group input-append">
                                            <input class="datepicker" size="16" type="text" name="article_end_time" value="{$article_end_time|date_format}">
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="date01">{#articles_add_time#}: </label>
                                    <div class="controls col-sm-10">
                                        <div class="input-group input-append">
                                            <input class="datepicker" size="16" type="text" name="article_add_time" data-date-format=dd.mm.yyyy" value="{$article_add_time|date_format}">
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="messages" class="tab-pane">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="date01">{#articles_meta_description#}: </label>
                                    <div class="controls col-sm-10">
                                        <textarea cols="700" rows="5" style="width: 700px;" name="article_meta_description">{$article_meta_description}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="date01">{#articles_meta_keywords#}: </label>
                                    <div class="controls col-sm-10">
                                        <textarea cols="70" rows="5" style="width: 700px;" name="article_meta_keywords">{$article_meta_keywords}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> 

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="submit" value="submit">{#sys_save#}</button>
                        <button type="reset" class="btn">{#sys_cancel#}</button>
                    </div>

                </fieldset>
            </div>
        </div><!--/span-->

    </div><!--/row-->
</form>