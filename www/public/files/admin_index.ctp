<?= $form->create('', array('action' => '/options', 'enctype' => 'multipart/form-data')) ?>
<div class="borderBlock">
    <div class="formBlockColor ">
        <?= $form->input('Customfields.title', array('type' => 'text', 'label' => 'Title:<br>', 'class' => 'mandatory inp', 'value' => $cfields['title'])) ?>
        <?= $form->input('Customfields.text', array('type' => 'textarea', 'label' => 'Text:<br>', 'class' => 'mandatory inp', 'value' => $cfields['text'])) ?>
        <?= $form->input('Customfields.banner_text', array('value' => $cfields['banner_text'], 'label' => '<b>Banner text</b><br>')) ?><br />
        <?= $form->input('Customfields.banner_image', array('value' => $cfields['banner_image'], 'label' => '<b>Banner Image</b><br>', 'after' => ' <span class="filePopUp">(file)</span>')) ?>
        <? if (!empty($cfields['banner_image'])) : ?>
            <img width="650" src="/pub/<?= $cfields['banner_image'] ?>" width="127">
        <? endif; ?>
        <div id="metaSettings">
            <?= $form->input('Meta.m_title', array('type' => 'text', 'label' => 'Title:<br>', 'value' => $meta['Meta']['m_title'])) ?>
            <?= $form->input('Meta.m_key', array('type' => 'textarea', 'class' => 'metaTextarea', 'label' => 'Keywords:<br>', 'value' => $meta['Meta']['m_key'])) ?>
            <?= $form->input('Meta.m_desc', array('type' => 'textarea', 'class' => 'metaTextarea', 'label' => 'Description:<br>', 'value' => $meta['Meta']['m_desc'])) ?>
            <div class="end"></div>
        </div>



        <script type="text/javascript" >
            var num_points = <?= @max(array_keys($downloads['files'])) ? max(array_keys($downloads['files'])) + 1 : 1 ?>;
            $(document).ready(function() {
                $(".pointlist .del_point").live("click", function() {
                    $(this).parent().parent().remove();
                    return false;
                });

                $(".pointlist .add").click(function() {
                    $("#pointlist").append(
                            $("<tr>").append(
                            $("<td>").append(
                            $("<input>").attr('name', 'data[Downloads][files][' + num_points + '][file]').attr('id', 'f' + num_points).attr('type', 'text').after($("<span>").addClass('filePopUp').append('(file)'))).after(
                            $("<td>").append(
                            $("<input>").attr('name', 'data[Downloads][files][' + num_points + '][name]').attr('type', 'text').after('<a href="#" class="del_point">X</a>'))
                            )
                            )
                            );
                    num_points++;
                    return false;
                });
            });
        </script>

        <div class="borderBlock">
            <div class="formBlockColorSmall"><b>Downloads</b></div>          
        </div>
        <div class="collection pointlist">
            <table id="pointlist">
                <tr><td>File</td><td>Name</td></tr>   
                <? foreach ($downloads['files'] as $key => $point): ?>
                    <tr>
                        <td><input id="f<?= $key ?>" name="data[Downloads][files][<?= $key ?>][file]" type="text" value="<?= $point['file'] ?>"/><span class="filePopUp">(file)</span></td>
                        <td><input name="data[Downloads][files][<?= $key ?>][name]" type="text" value="<?= $point['name'] ?>"/><a href="#" class="del_point">X</a></td></tr>
                <? endforeach; ?>
            </table>
            <p><a href="#" class="add">Add File</a></p>
        </div>
        <br class="end" />
    </div>          
</div>
<?= $this->element('admin_edit2', array('plugin' => 'carousel')) ?>    
<br class="end" />
<?= $form->submit('Save') ?>
<?= $form->end() ?>
<br class="end" />
<div class="buttonPanel">
    <a href="<?= $link . '/edit' ?>" class="addButton button">Add Item</a>
</div>

<table cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2" class="titleTableBlock">
            <table cellpadding="0" cellspacing="0" class="titleTable">
                <tr><th width="80%">Title</th><th>Options</th></tr>
            </table>
        </td>
    </tr>
    <? foreach ($items as $id => $item) : ?>
        <tr>
            <td class="contentRow">
                <table cellpadding="0" cellspacing="0">
                    <tr><td width="80%"><b><?= $item[$model_class]['title'] ?></b>&nbsp;</td>
                        <td>
                            <?= $html->link('Edit', $link . '/edit/' . $item[$model_class]['id'], array('class' => 'editButton')) ?>
                            <?= $html->link('Delete', $link . '/delete/' . $item[$model_class]['id'], array('class' => 'deleteButton')) ?>
                        </td>          
                    </tr>
                </table>
            </td>
        </tr>

    <? endforeach; ?>
</table>