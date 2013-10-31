{strip}
<h1>Здесь зарабатывают на выполнении заданий</h1>
Внимательно прочтите и точно следуйте инструкции к выполнению задания.
Рекламодатель имеет право отклонить вашу работу,
если условия выполнения не были соблюдены в полной мере.
Помните так же, что существует максимальный срок,
за который вы должны успеть выполнить задание.
По истечении этого срока заявка на выполнение аннулируется.
<div class="tskblank4">
  <div class="tskblank3">
    <div class="tskblank2">
      <div class="tskblank1">
        <span class="tskblank-title">
          № {$task.id}: «{$task.displayname}»
          {if 1}
          <div style="float:right;">
            <a href="/index.php?module=work&type=user&func=task_modify&id={$task.id}"><img border="0" src="/public/images/system/edit.gif" alt="Редактировать"></a>&nbsp;
            <a href="/index.php?module=work&type=user&func=task_delete&id={$task.id}"><img border="0" src="/public/images/system/del.gif" alt="Удалить"></a>
          </div>
          {/if}
        </span>
        <div class="tskblock">
          <table class="tsk-header">
            <tbody>
              <tr>
                <td style="vertical-align: top; padding-right: 8px; width: 10%;">
                  <img class="avatar" src="/images/def-avatar.jpg" alt="avatar" style="margin-top: 0;">
                </td>
                <td style="vertical-align: top; white-space:nowrap;">
                  <b>Автор задания:</b>
                  <br>
                  <a class="tsk-mail" href="/mailnew.php?mailto=268237" target="_blank" title="Написать автору задания">
                  </a>ID: <a href="/userinfo.php?user=268237">268237 - bredsmith</a>
                  <br>
                  <a class="alltasks" href="/work-task.php?taskuser=268237" target="_blank">Посмотреть все задания автора</a>
                  <br>
                  <table class="tskstat">
                    <tbody>
                      <tr>
                        <td>Рейтинг</td>
                        <td>
                          <span class="rating5w" title="Отзывы о задании: Отличное">
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td>Отзывы о задании&nbsp;&nbsp;&nbsp;</td>
                        <td>
                          <a class="alltasks" href="/work-task-feed.php?adv=58846&amp;tus=268237&amp;cnt=d6560f8dabea829cf4dcae6df0ef8dac">6 - прочитать</a>
                        </td>
                      </tr>
                      <tr>
                        <td>Статус</td>
                        <td>
                          <span style="color: #C06606;">Многоразовое</span>
                        </td>
                      </tr>
                      <tr>
                        <td>Выполнено</td>
                        <td>
                          <span style="color: #34A305;" title="Одобрено">215</span>
                          / <span style="color: #B1051E;" title="Отклонено">5</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
                <td style="vertical-align: top;">
                  <span class="taskprice-note">{$task.currency} <span style="font-size: 12px;">руб</span></span>
                  <span class="taskprice">Цена выполнения</span>
                  <form name="taskfavform" method="post" action="">
                    <input name="cnt" value="6371abc49a91d6676352ec902f1f506e" type="hidden">
                    <input name="adv" value="58846" type="hidden">
                  </form>
                  <span id="t-fail" class="task-fail" title="Не видеть больше этого задания!" onclick="senddata(document, 5)" ;="">
                  </span>
                  <span id="t-favout" style="display: none;" class="task-favoriteout" title="Исключить задание из Избранного" onclick="senddata(document, 4)" ;=""></span>
                  <span id="t-fav" class="task-favorite" title="Добавить задание в Избранное" onclick="senddata(document, 3)" ;=""></span>
                </td>
              </tr>
            </tbody>
          </table>
          <span class="task-subtitle">Описание задания:</span>
          <span class="taskdescription">
            {$task.description}
          </span>
          <span class="task-subtitle">Что нужно знать для выполнения задания:</span>
          <span class="taskquestion">
            {$task.addinfo}
          </span>

          <span class="task-subtitle">Внимание!</span>
          <b>На выполнение этого задания выделяется не более 1 часа!</b>
          <br>Чтобы выполнить задание, нажмите на кнопку «Начать выполнение».
          Необходимую подтверждающую информацию о выполнении задания нужно будет ввести здесь же, на странице задания.
          Успехов!
          <form name="goform" method="post" action="/gotask.php" target="_blank">
            <input name="cnt" value="6371abc49a91d6676352ec902f1f506e" type="hidden">
            <input name="adv" value="58846" type="hidden">
          </form>
          <center>
            <span class="button-green-big" style="margin-top: 10px;" title="Приступить к выполнению задания" onclick="javascript:gotask();">Начать выполнение!</span>
            <span class="desctext">Будет произведён переход на сайт<br>http://www.cosmo.ru/sp/htc/profile.php?RESULT_ID=323957</span>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>
{/strip}