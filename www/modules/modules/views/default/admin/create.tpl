{strip}
    <form method="post" class="form-horizontal">
        <div class="row-fluid">
            <div class="box span12">
                <div class="box-header well" data-original-title>
                    <h2><i class="icon-edit"></i> {#user_edit#}</h2>
                </div>
                <div class="box-content">

                    <fieldset>
                        {* <legend>Manage form</legend>*}
                        <br><br>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="date01">{#module_name#}</label>
                            <div class="controls col-sm-5">
                                <input type="text" name='login' class="form-control" size='40' value='{$user->login}'>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="date01">{#module_type#}</label>
                            <div class="controls col-sm-5">
                                {html_options name=gid options=$groups_list selected=$user->gid class='form-control selectpicker'}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="date01">{#module_displayname#}</label>
                            <div class="controls col-sm-5">
                                <input type="text" name='login' class="form-control" size='40' value='{$user->login}'>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="date01">{#module_version#}</label>
                            <div class="controls col-sm-5">
                                <input type="text" name='mail' class="form-control" size='40' value='{$user->mail|default:'1.0.0'}'>
                            </div>
                        </div>
                            
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="date01">{#module_author#}</label>
                            <div class="controls col-sm-5">
                                <input type="text" name='mail' class="form-control" size='40' value='{$user->mail}'>
                            </div>
                        </div>
                            
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="date01">{#module_contact#}</label>
                            <div class="controls col-sm-5">
                                <input type="text" name='mail' class="form-control" size='40' value='{$user->mail}'>
                            </div>
                        </div>
                            
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="date01">{#module_description#}</label>
                            <div class="controls col-sm-5">
                                <textarea class="form-control">{$user->mail}</textarea>
                            </div>
                        </div>
                            
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="date01">{#module_changelog#}</label>
                            <div class="controls col-sm-5">
                                <textarea class="form-control">{$user->mail}</textarea>
                            </div>
                        </div>

                        <div class="form-actions col-sm-8">
                            <button type="submit" class="btn btn-primary" name="submit" value="true">{#sys_save#}</button>
                            <button type="reset" class="btn btn-default">Cancel</button>
                        </div>
                    </fieldset>


                </div>
            </div><!--/span-->

        </div><!--/row-->
    </form>
{/strip}