{strip}
  <h3>Персональные данные пользователя</h3>
  <table width="100%">
    <tr>
      <td width="150" valign="top">
        <table class="profile_photo" border="0" cellpadding="0" cellspacing="0" style="width: 150px; height: 100%;padding: 0px">
          <thead>
            <tr>
              <th>
                Фото
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding: 0px ; height: 100%">
                {if $photo_w}
                  {assign var=fname value=$id|string_format:"%08d"}
                  {if !$photo_r}
                    {assign var=photo_r value=0}
                  {/if}
                  <img id='previewField' style="max-height: 400px; max-width: 150px;" src="/images/user/photo/{$fname[7]}/{$fname[6]}/{$fname}/{$fname}_w{$photo_w}_{$photo_r}.jpg" alt="Фотография" border="0"  align="center" >
                {else}
                  <img id='previewField' style="max-height: 400px; max-width: 150px;" src="/images/no_photo.jpg" alt="Фотография" border="0"  align="center" >
                {/if}
              </td>
            </tr>
          </tbody>
        </table>
      </td>
      <td valign="top">
        <table class="profile" border="0" cellpadding="0" cellspacing="0"  width="100%">
          <thead>
            <tr>
              <th nowrap="nowrap" align="center" width="200">Параметр</th>
              <th nowrap="nowrap" align="center">Значение</th>
            </tr>
          </thead>
          <tbody>
            <tr>
               <td>Ник</td>
               <td class="value">{$login}</td>
            </tr>
            <tr>
               <td>E-mail</td>
               <td class="value">{$mail}</td>
            </tr>

            <tr>
              <td>Род деятельности</td>
              <td class="value">
                {$prof_list[$prof_id]}
              </td>
            </tr>
            <tr>
              <td>Семейное положение</td>
              <td class="value">
                {$family_list[$family_id]}
              </td>
            </tr>
            <tr>
              <td>Пол</td>
              <td class="value">
                {$sex_list[$sex_id]}
              </td>
            </tr>
            <tr>
              <td>Регистрационный номер</td>
              <td class="value">
                {$id}
              </td>
            </tr>
            <tr>
              <td>Зарегистрирован</td>
              <td class="value">
                {$addtime|date_format:"%d.%m.%Y в %H:%M"}
              </td>
            </tr>
            <tr>
              <td>Последний визит</td>
              <td class="value">
                {$last_visit|date_format:"%d.%m.%Y в %H:%M"}
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </table>

  <h3>Мои платёжные реквизиты</h3>
  <table class="profile" border="0" cellpadding="0" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th nowrap="nowrap" align="center" width="51%">Платёжная система</th>
        <th nowrap="nowrap" align="center">Номер кошелька</th>
      </tr>
    </thead>
      <tbody>
        <tr>
          <td nowrap="nowrap">Номер счёта в системе <a href="https://www.liqpay.com" target="_blank">LiqPay</a></td>
          <td class="value">{$liqpay}</td>
        </tr>
        <tr>
          <td nowrap="nowrap">Номер счёта в системе <a href="https://www.alertpay.com/?1OK3KSy62IYmKce8Iy5XwQ%3d%3d" target="_blank">AlertPay</a></td>
          <td class="value">{$alertpay}</td>
        </tr>
        <tr>
          <td nowrap="nowrap">Номер счёта в системе <a href="http://www.webmoney.ru" target="_blank">WebMoney</a> (WMR)</td>
          <td class="value">{$webmoney}</td>
        </tr>
        <tr>
          <td nowrap="nowrap">Идентификатор в системе <a href="http://www.webmoney.ru" target="_blank">WebMoney</a> (WMID)</td>
          <td class="value">{$wmid}</td>
        </tr>
      </tbody>
  </table>
{/strip}
