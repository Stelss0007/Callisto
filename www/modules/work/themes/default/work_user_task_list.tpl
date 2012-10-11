{strip}
 <h2>Зарабатывай на выполнении заданий</h2>

            <table class='navigation'>
              <tr>
               <td class='orient'>
                  <span class='navygray'>
                    <span class='text14'>&larr;</span>
                    &nbsp;Предыдущая</span>
                </td>
                <td width='90%'>
                  <span class='selpage-act'>1</span>
                  <a class='selpage' href='work-task.php?p=2&hc=5207'>2</a>
                  <a class='selpage' href='work-task.php?p=3&hc=5207'>3</a>
                  <a class='selpage' href='work-task.php?p=4&hc=5207'>4</a>
                  <a class='selpage' href='work-task.php?p=5&hc=5207'>5</a>
                  <a class='selpage' href='work-task.php?p=6&hc=5207'>6</a>
                  <a class='selpage' href='work-task.php?p=7&hc=5207'>7</a>
                  <a class='selpage' href='work-task.php?p=8&hc=5207'>8</a>
                  <a class='selpage' href='work-task.php?p=9&hc=5207'>9</a>
                  &hellip;
                  <a class='selpage' href='work-task.php?p=261&hc=5207'>261</a>
                 </td>
                 <td>
                     <a href='work-task.php?p=2&hc=5207' style='border: none;'>Следующая&nbsp;
                         <span class='text14'>&rarr;</span>
                     </a>
                  </td>
             </tr>
           </table>
           <table class='work-serf'>
             {foreach from=$task_list item=task}
               <tr>
                 <td class='normal' width='40' valign='top'>
                     <span id='adstatus52878' class='taskimg' title='Можете выполнить это задание'></span>
                 </td>
                 <td class='normal'>
                   <a href='index.php?module=work&type=user&func=task_view&id={$task.id}' target='_blank'>
                       {$task.displayname}
                        <br />
                       <span class='desctext'>
                           http://wmzona.com/gptr/index.php?r=529265
                       </span>
                       <br />
                       <span class='desctext2'>
                           № {$task.id} - Регистрация + активность{$category[$task.category_id]}
                       </span>
                    </a>
                </td>
                <td class='normal' nowrap='nowrap' valign='middle' style='width: 60px; text-align: right; padding-right: 10px;'>
                    <span class='clickprice' style='margin-right: 10px;'>
                        {if $task.currency}
                          {$task.currency}
                        {else}
                          --
                        {/if} руб
                    </span>
                    <span class='rating0'></span>
                </td>
              </tr>
            {/foreach}
         </table>
         <table class='navigation'>
             <tr>
                 <td class='orient'>
                     <span class='navygray'>
                         <span class='text14'>&larr;</span>
                         &nbsp;Предыдущая
                     </span>
                 </td>
                 <td width='90%'>
                     <span class='selpage-act'>1</span>
                     <a class='selpage' href='work-task.php?p=2&hc=5207'>2</a>
                     <a class='selpage' href='work-task.php?p=3&hc=5207'>3</a
                     <a class='selpage' href='work-task.php?p=4&hc=5207'>4</a>
                     <a class='selpage' href='work-task.php?p=5&hc=5207'>5</a>
                     <a class='selpage' href='work-task.php?p=6&hc=5207'>6</a>
                     <a class='selpage' href='work-task.php?p=7&hc=5207'>7</a>
                     <a class='selpage' href='work-task.php?p=8&hc=5207'>8</a>
                     <a class='selpage' href='work-task.php?p=9&hc=5207'>9</a>
                     &hellip;
                     <a class='selpage' href='work-task.php?p=261&hc=5207'>261</a>
                 </td>
                 <td>
                     <a href='work-task.php?p=2&hc=5207' style='border: none;'>
                         Следующая&nbsp;
                         <span class='text14'>&rarr;</span>
                     </a>
                 </td>
             </tr>
        </table>
        <div style="text-align: center">
          [<a href="/index.php?module=work&type=user&func=task_new">Добавить</a>]
        </div>

{/strip}