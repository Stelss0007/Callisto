{strip}
<h1>��� ������ ������</h1>

��������� ������������!
������ ��������� ����������� ��� ���������� ������ ������� �������,
�������� ����� ����������� ���������.
� ��������� ����� ������� ���������.
�������������� ���, ���� � ���-���� ������������.
<form action="index.php?module=user&type=user&func=previmg" method="post" name="img_form" id="img_form">
   <input name="file" id = 'fileinputajax' style="display: none;" size="10" type="file">
</form>

<form action="index.php?module=user&type=user&func=create_user" method="post" enctype="multipart/form-data" name="reg_form" id="reg_form">
  <h3>��� ������������ ������ (���������� ��� ��������� ������� "�������")</h3>
  <table width="100%">
    <tr>
      <td width="150" valign="top">
        <table class="profile_photo" border="0" cellpadding="0" cellspacing="0" style="width: 150px; height: 100%;padding: 0px">
          <thead>
            <tr>
              <th>
                ��� ����
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding: 0px ; height: 100%">
                <img id='previewField' style="max-height: 400px; max-width: 150px;" src="/images/no_photo.jpg" alt="����������" border="0"  align="center" >
              </td>
            </tr>
            <tr>
              <td>
                {*�������� ����:*}
                
                {*<input type="text" id="fileinput_fname" value="" onclick="$('#fileinput').click();"/>*}
                <span id="img_name" style="color: green; font-weight: bold;"></span>
                <input type="button" style="width: 100%;" value="�������� ����" onclick="$('input#fileinput').trigger('click');alert('111')"/>
                <input name="file" id = 'fileinput' style="width: 150px; opacity: 0; filter:alpha(opacity: 0);  position: relative; top: -20px; left: 0px; height: 15px; cursor: pointer;" size="10" type="file" onchange="imgPreview(this)">
              </td>
            </tr>
          </tbody>
        </table>
      </td>
      <td valign="top">
        <table class="profile" border="0" cellpadding="0" cellspacing="0"  width="100%">
          <thead>
            <tr>
              <th nowrap="nowrap" align="center" width="51%">��������</th>
              <th nowrap="nowrap" align="center">��������</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
               <td>�����* :</td>
               <td class="value"><input type="text" name="login" value="" size="25" maxlength="30" class="required" minlength="3" /></td>
               <td class="service"></td>
            </tr>
            <tr>
               <td>������* :</td>
               <td class="value"><input type="password" name="pass" value="" size="25" maxlength="30" class="required" minlength="6" /></td>
               <td class="service"></td>
            </tr>
            <tr>
               <td>��������� ������* :</td>
               <td class="value"><input type="password" name="pass2" value="" size="25" maxlength="30" class="required" minlength="6" /></td>
               <td class="service"></td>
            </tr>
            <tr>
               <td>E-mail* :</td>
               <td class="value"><input type="text" name="mail" value="" size="25" maxlength="30" class="required email" /></td>
               <td class="service"></td>
            </tr>

            <tr>
              <td>��� ��� ������������</td>
              <td class="value">
                <select class="val" name="prof_id">
                    {html_options options=$prof_list}
                </select>
              </td>
              <td class="service"><span class="hint-quest"><div  style="display: none;" class="tooltip fixed">���� ����� ������ ����� �������� ���� ��� ��� ������������ ���������</div></span></td>
            </tr>
            <tr>
              <td>�� �������� ���������</td>
              <td class="value">
                <select class="val" name="family_id">
                    {html_options options=$family_list}
                </select>
              </td>
              <td class="service"><span class="hint-quest">
                  <div style="display: none;" class="tooltip fixed">���� ����� ������ ����� �������� ���� ���� �������� ��������� ���������</div>
                </span>
              </td>
            </tr>
            <tr>
              <td>��� ���</td>
              <td class="value">
                <select class="val" name="sex_id">
                  {html_options options=$sex_list}
                </select>
              </td>
              <td class="service"></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </table>

  <h3>��� �������� ���������</h3>
  <table class="profile" border="0" cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th nowrap="nowrap" align="center" width="51%">�������� �������</th>
            <th nowrap="nowrap" align="center">����� ��������</th>
            <th></th>
        </tr>
    </thead>
      <tbody>
        <tr>
          <td nowrap="nowrap">����� ����� � ������� <a href="https://www.liqpay.com" target="_blank">LiqPay</a></td>
          <td class="value"><input class="val" name="liqpay" size="30" maxlength="18" value="" type="text"></td>
          <td class="service">
            <span class="hint-quest">
              <div style="display: none;" class="tooltip fixed">
                ������� ����� � �������� ������� <b>LiqPay</b>
                �������� ����� ������<br>���������� �������� � ������������� �������,
                ��������:
                <ul>
                  <li>��� �������: <b>38XXXYYYYYYY</b></li>
                  <li>��� ������: <b>7XXXYYYYYYY</b></li>
                  <li>��� ��������: <b>375XXYYYYYYY</b></li>
                </ul>
                ��� <b>XXX</b> - ��� ���������, � <b>YYYYYYY</b> - ����� ��������<br>
                <a href="https://www.liqpay.com" target="_blank">
                  ������� �� ���� �������� ������� LiqPay
                </a>
              </div>
            </span>
          </td>
        </tr>
        <tr>
          <td nowrap="nowrap">����� ����� � ������� <a href="https://www.alertpay.com/?1OK3KSy62IYmKce8Iy5XwQ%3d%3d" target="_blank">AlertPay</a></td>
          <td class="value"><input class="val" name="alertpay" size="30" maxlength="40" value="" type="text"></td>
          <td class="service">
            <span class="hint-quest">
              <div style="display: none;" class="tooltip fixed">
                ������� ����� � �������� ������� <b>AlertPay</b> �������� ��� �����<br>����������� ����� (e-mail),
                ������� �� ��������� ��� ����������� � AlertPay.<br>
                <a href="https://www.alertpay.com/?1OK3KSy62IYmKce8Iy5XwQ%3d%3d" target="_blank">
                  ������� �� ���� �������� ������� AlertPay
                </a>
              </div>
            </span>
          </td>
        </tr>
        <tr>
          <td nowrap="nowrap">����� ����� � ������� <a href="http://www.webmoney.ru" target="_blank">WebMoney</a> (WMR)</td>
          <td class="value"><input class="val" name="webmoney" size="30" maxlength="13" style="text-transform: uppercase;" value="" type="text"></td>
          <td class="service">
            <span class="hint-quest">
              <div style="display: none;" class="tooltip fixed">
                ����� ����� � �������� ������� <b>WebMoney</b> ����������� � ������ (WMR-������)<br>
                � ������� <b>R000000000000</b> (������� ��������� ����� <b>R</b> � ����� �����)<br>
                <a href="http://www.webmoney.ru" target="_blank">
                  ������� �� ���� �������� ������� WebMoney
                </a>
              </div>
            </span>
            </td>
        </tr>
        <tr>
          <td nowrap="nowrap">������������� � ������� <a href="http://www.webmoney.ru" target="_blank">WebMoney</a> (WMID)</td>
          <td class="value"><input class="val" name="wmid" size="30" maxlength="12" style="text-transform: uppercase;" value="" type="text"></td>
          <td class="service"></td>
        </tr>
      </tbody>
  </table>

  <table width="100%">
     <tfoot>
       <tr>
         <td align="center">
           <input class="button-blue" type="reset" name="reset" value="��������" />
           <input class="button-blue" type="submit" name="ok" value="������" />
         </td>
      </tr>
    </tfoot>
  </table>
 
</form>
{/strip}


{literal}
<script language="javascript">
  $('#reg_form').validate();
    
  $('.hint-quest').hover(
    function(){
      $(this).find("div.tooltip").show();
    },
  
    function(){
      $(this).find("div.tooltip").hide();
    }
  );

</script>
{/literal}