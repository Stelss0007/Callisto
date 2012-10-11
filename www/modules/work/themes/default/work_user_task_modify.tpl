{strip}
<h3>Оплачиваемые задания</h3>На <span class="seosprint"><span>SEO</span> sprint</span> есть много желающих выполнять несложные задания за небольшую плату.
Насколько востребованным и интересным будет ваше задание зависит только от вас. Не скупитесь на вознаграждение.
Минимальная цена одного задания на <span class="seosprint"><span>SEO</span> sprint</span> — 0.20 руб.
<h3>Форма для размещения задания</h3>
<form method="POST" action="/index.php?module=work&type=user&func=task_update">

              <input type='hidden' name="id" value="{$task.id}">
              <table class="profile" style="margin-bottom: 0;">
                  <thead>
                      <tr>
                          <th nowrap="nowrap" width="42%" align="center">Параметр</th>
                          <th nowrap="nowrap" align="center">Значение</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td><b>Заголовок задания</b></td>
                          <td class="value"><input class="val" name="displayname" maxlength="55" value="{$task.displayname}" type="text"></td>
                          <td class="service"><span id="hint1" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>Заголовок задания</b> - максимум 55 символов.<br>Заголовок должен быть коротким и понятным.<br>Соблюдайте грамматику. Небрежное написание оттолкнёт посетителей.<br>Не пишите всё ЗАГЛАВНЫМИ БУКВАМИ, не ставьте множество однотипных<br>знаков типа: !!!!!! и т.д. После запятой правильно ставить знак пробела.</div></span></td>
                      </tr>
                      <tr>
                          <td>Категория задания</td>
                          <td class="value">
                              <select class="val" name="category_id">
                                  <option value="1">Только регистрация</option>
                                  <option value="9">Только клики</option>
                                  <option value="2" selected="selected">Регистрация с активностью</option>
                                  <option value="3">Постинг в форумы и/или блоги</option>
                                  <option value="4">Написать статью или пресс-релиз</option>
                                  <option value="5">Отзыв/проголосовать</option>
                                  <option value="6">Forex</option>
                                  <option value="7">Играть в игры</option>
                                  <option value="8">Инвестировать</option>
                                  <option value="0">Прочее</option>
                              </select>
                          </td>
                          <td class="service"></td>
                      </tr>
                      <tr>
                          <td><b>Описание задания ?</b></td>
                          <td colspan="2">

                          </td>
                      </tr>
                      <tr>
                          <td class="value" colspan="2">
                              <textarea style="height: 100px;" cols="40" rows="3" name="description">{$task.description}</textarea>
                          </td>
                          <td class="service"><span id="hint2" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>Описание задания</b> - максимум 3000 символов.<br>Описание задания должно быть информативным и понятным.<br>Соблюдайте грамматику. Небрежное написание оттолкнёт посетителей.<br>Не пишите всё ЗАГЛАВНЫМИ БУКВАМИ, не ставьте множество однотипных<br>знаков типа: !!!!!! и т.д. После запятой правильно ставить знак пробела.<br>Уважайте читателей и модератора.<br><br>Если текст написан настолько безграмотно или небрежно<br>что модератору станет противно его читать,<br>он вправе будет просто забраковать всё задание.</div></span></td>
                      </tr>
                      <tr>
                          <td colspan="3"><b>Что должен указать исполнитель для проверки выполнения задания ?</b></td>
                      </tr>
                      <tr>
                          <td class="value" colspan="2">
                              <textarea style="height: 100px;" cols="40" rows="3" name="addinfo" >{$task.addinfo}</textarea>
                          </td>
                          <td class="service"><span id="hint4" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>Условия выполнения</b> - максимум 3000 символов.<br>Максимально точно и понятно напишите, что должен будет указать пользователь,<br>когда будет отчитываться о проделанной работе.</div></span></td>
                      </tr>
                      <tr>
                          <td><b>URL сайта</b> (включая http://)</td>
                          <td class="value"><input class="val" name="ask_url" maxlength="300" value="http://" type="text"></td>
                          <td class="service"><span id="hint3" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>URL-адрес сайта</b> должен начинаться с http:// или https://<br>и содержать не более 300 символов. Не используйте HTML-теги и Java-скрипты.<br>За попытки взлома системы, наказание - удаление аккаунта</div></span></td>
                      </tr>
                      <tr>
                          <td><b>Вознаграждение исполнителю</b></td>
                          <td class="value"><input class="val" name="currency" maxlength="6" value="{$task.currency}" type="text"></td>
                          <td class="service"><span id="hint5" class="hint-quest"><div style="display: none;" class="tooltip fixed">Плата (в рублях), которую получит пользователь за успешное выполнение вашего задания.<br>Пожалуйста, указывайте справедливую, адекватную цену.<br>Это безусловно повысит ваш рейтинг в глазах других исполнителей.</div></span></td>
                      </tr>
                                                              
                      <tr>
                          <td>Максимальный срок, отведённый на выполнение задания</td>
                          <td class="value">
                              <select class="val" name="ask_days">
                                  <option value="90">1 час</option>
                                  <option value="91">2 часа</option>
                                  <option value="92">6 часов</option>
                                  <option value="0">12 часов</option>
                                  <option value="1">1 день</option>
                                  <option value="2">2 дня</option>
                                  <option value="3" selected="selected">3 дня</option>
                                  <option value="4">4 дня</option>
                                  <option value="5">5 дней</option>
                                  <option value="6">6 дней</option>
                                  <option value="7">7 дней</option>
                                  <option value="10">10 дней</option>
                                  <option value="15">15 дней</option>
                                  <option value="20">20 дней</option>
                                  <option value="30">30 дней</option>
                              </select>
                          </td>
                          <td class="service"><span id="hint6" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>Максимальный срок выполнения</b> - это максимальный срок, за который<br>пользователь должен выполнить ваше задание. Если по истечении этого срока<br>исполнитель не подаст отчёт о выполнении, его заявка на выполнение будет отменена.</div></span></td>
                      </tr>

                      <tr id="targetblockopen">
                          <td class="centerlink" colspan="3" onclick="javascript:targetopen();">Открыть расширенный выбор целевой аудитории&nbsp;&nbsp;(+ 0.100 руб.)</td>
                      </tr>
                  </tbody>
              </table>

              
              <center>
                  <p>
                      <a href="/tos.php#p3" target="_blank">Прочтите правила (ссылка откроется в новом окне)</a><br>
                      <input name="tosaccept" value="1" type="checkbox">Я согласен(на) с правилами размещения рекламы на SEO sprint
                  </p>
                  <input type="submit" class="button-green" title="Разместить тест" value="Сохранить">
              </center>


</form>

{/strip}