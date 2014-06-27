{strip}
{appCssLoad modname=comments}
<div class="comments">
{if $comment_list}
{foreach from=$comment_list item=comment}
  <div class='comment_{$comment.id} comment'>
    <a name='comment_{$comment.id}'></a>
    <div class="comment_user_info">
      <a target="_blank" href="/user/Роман103/">
        <img width="90" alt="" src="/public/images/avatars/noavatar.png" class="img-rounded img-responsive center-block">
      </a>
      <br>
      <a href='/user/{$comment.login}'>{$comment.login}</a>
    </div>
    <div class="comment_body">
      <div class="comment_title">
         {#comments_added_date_title#} {$comment.comment_addtime|date_time_format}
      </div>
      {$comment.comment_text|bbcode|smile}
    </div>
    <div class="clear"></div>
  </div>
{/foreach}
{else}
  {#comments_empty#} <br>
{/if}
</div>



<h3>Добавить коментарий</h3>
<div style="width: 100%; position: relative;">
  <form action="/comments/comment_add" method="post">
    <input type="hidden" name="comment_module_object" value="{$module_object}">
    <input type="hidden" name="comment_module" value="{$module_name}">
    {bbeditor name=comment_text toolbar=$toolbar}
    <input type="submit" name="comment_submit" value="submit">
    <br><br>
  </form>
</div>
{/strip}