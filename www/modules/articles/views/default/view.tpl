{appCssLoad modname=articles}

<div class="article-list">

  <div class="article-list-item">
    <div class="clearfix">
      <b>
        <a href="/articles/view/{$article->id}">
          {$article->article_title|escape}
        </a>
      </b>
    </div>
    <div class="article-info">
      <div>
        <b>{#sys_added#}:</b> {$article->article_add_time|date_format}
      </div>
      <div>
        <b>{#sys_author#}:</b> <a href="/articles/user/{$article->article_user_id}">{$article_user_list[$article->article_user_id]}</a>
      </div>
      <div>
        <b>{#sys_category#}:</b> <a href="/articles/category/{$article->article_category_id}">{$article_category_list[$article->article_category_id]}</a>
      </div>
    </div>
    <div class="article-description">
        {$article->article_description} 
    </div>
  </div> 
</div>
