{strip}
{appCssLoad modname=articles}
<div class="article-list">
{foreach from=$articles_list item=article}
  {cycle name="articles" values="even, odd" assign="class" print=false}
  <div class="article-list-item">
    <b>
      <a href="/articles/view/{$article.id}">
        {$article.article_title|escape}
      </a>
    </b>
    <div class="article-info">
      <div>
        <b>{#sys_added#}:</b> {$article.article_add_time|date_format}
      </div>
      <div>
        <b>{#sys_author#}:</b> <a href="/articles/user/{$article.article_user_id}">{$article_user_list[$article.article_user_id]}</a>
      </div>
      <div>
        <b>{#sys_category#}:</b> <a href="/articles/category/{$article.article_category_id}">{$article_category_list[$article.article_category_id]}</a>
      </div>
    </div>
    <div class="article-description">
        {$article.article_description|strip_tags|substr:0:800} 
    </div>
    <div class="clear"></div>
  </div> 
{/foreach}
</div>
<div>
  {pagination paging_element_count=7}
</div>
{/strip}
