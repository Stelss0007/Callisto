{strip}
<h3>������������ �������</h3>�� <span class="seosprint"><span>SEO</span> sprint</span> ���� ����� �������� ��������� ��������� ������� �� ��������� �����.
��������� �������������� � ���������� ����� ���� ������� ������� ������ �� ���. �� ��������� �� ��������������.
����������� ���� ������ ������� �� <span class="seosprint"><span>SEO</span> sprint</span> � 0.20 ���.
<h3>����� ��� ���������� �������</h3>
<form method="POST" action="/index.php?module=work&type=user&func=task_update">

              <input type='hidden' name="id" value="{$task.id}">
              <table class="profile" style="margin-bottom: 0;">
                  <thead>
                      <tr>
                          <th nowrap="nowrap" width="42%" align="center">��������</th>
                          <th nowrap="nowrap" align="center">��������</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td><b>��������� �������</b></td>
                          <td class="value"><input class="val" name="displayname" maxlength="55" value="{$task.displayname}" type="text"></td>
                          <td class="service"><span id="hint1" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>��������� �������</b> - �������� 55 ��������.<br>��������� ������ ���� �������� � ��������.<br>���������� ����������. ��������� ��������� �������� �����������.<br>�� ������ �� ���������� �������, �� ������� ��������� ����������<br>������ ����: !!!!!! � �.�. ����� ������� ��������� ������� ���� �������.</div></span></td>
                      </tr>
                      <tr>
                          <td>��������� �������</td>
                          <td class="value">
                              <select class="val" name="category_id">
                                  <option value="1">������ �����������</option>
                                  <option value="9">������ �����</option>
                                  <option value="2" selected="selected">����������� � �����������</option>
                                  <option value="3">������� � ������ �/��� �����</option>
                                  <option value="4">�������� ������ ��� �����-�����</option>
                                  <option value="5">�����/�������������</option>
                                  <option value="6">Forex</option>
                                  <option value="7">������ � ����</option>
                                  <option value="8">�������������</option>
                                  <option value="0">������</option>
                              </select>
                          </td>
                          <td class="service"></td>
                      </tr>
                      <tr>
                          <td><b>�������� ������� ?</b></td>
                          <td colspan="2">

                          </td>
                      </tr>
                      <tr>
                          <td class="value" colspan="2">
                              <textarea style="height: 100px;" cols="40" rows="3" name="description">{$task.description}</textarea>
                          </td>
                          <td class="service"><span id="hint2" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>�������� �������</b> - �������� 3000 ��������.<br>�������� ������� ������ ���� ������������� � ��������.<br>���������� ����������. ��������� ��������� �������� �����������.<br>�� ������ �� ���������� �������, �� ������� ��������� ����������<br>������ ����: !!!!!! � �.�. ����� ������� ��������� ������� ���� �������.<br>�������� ��������� � ����������.<br><br>���� ����� ������� ��������� ����������� ��� ��������<br>��� ���������� ������ �������� ��� ������,<br>�� ������ ����� ������ ����������� �� �������.</div></span></td>
                      </tr>
                      <tr>
                          <td colspan="3"><b>��� ������ ������� ����������� ��� �������� ���������� ������� ?</b></td>
                      </tr>
                      <tr>
                          <td class="value" colspan="2">
                              <textarea style="height: 100px;" cols="40" rows="3" name="addinfo" >{$task.addinfo}</textarea>
                          </td>
                          <td class="service"><span id="hint4" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>������� ����������</b> - �������� 3000 ��������.<br>����������� ����� � ������� ��������, ��� ������ ����� ������� ������������,<br>����� ����� ������������ � ����������� ������.</div></span></td>
                      </tr>
                      <tr>
                          <td><b>URL �����</b> (������� http://)</td>
                          <td class="value"><input class="val" name="ask_url" maxlength="300" value="http://" type="text"></td>
                          <td class="service"><span id="hint3" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>URL-����� �����</b> ������ ���������� � http:// ��� https://<br>� ��������� �� ����� 300 ��������. �� ����������� HTML-���� � Java-�������.<br>�� ������� ������ �������, ��������� - �������� ��������</div></span></td>
                      </tr>
                      <tr>
                          <td><b>�������������� �����������</b></td>
                          <td class="value"><input class="val" name="currency" maxlength="6" value="{$task.currency}" type="text"></td>
                          <td class="service"><span id="hint5" class="hint-quest"><div style="display: none;" class="tooltip fixed">����� (� ������), ������� ������� ������������ �� �������� ���������� ������ �������.<br>����������, ���������� ������������, ���������� ����.<br>��� ���������� ������� ��� ������� � ������ ������ ������������.</div></span></td>
                      </tr>
                                                              
                      <tr>
                          <td>������������ ����, ��������� �� ���������� �������</td>
                          <td class="value">
                              <select class="val" name="ask_days">
                                  <option value="90">1 ���</option>
                                  <option value="91">2 ����</option>
                                  <option value="92">6 �����</option>
                                  <option value="0">12 �����</option>
                                  <option value="1">1 ����</option>
                                  <option value="2">2 ���</option>
                                  <option value="3" selected="selected">3 ���</option>
                                  <option value="4">4 ���</option>
                                  <option value="5">5 ����</option>
                                  <option value="6">6 ����</option>
                                  <option value="7">7 ����</option>
                                  <option value="10">10 ����</option>
                                  <option value="15">15 ����</option>
                                  <option value="20">20 ����</option>
                                  <option value="30">30 ����</option>
                              </select>
                          </td>
                          <td class="service"><span id="hint6" class="hint-quest"><div style="display: none;" class="tooltip fixed"><b>������������ ���� ����������</b> - ��� ������������ ����, �� �������<br>������������ ������ ��������� ���� �������. ���� �� ��������� ����� �����<br>����������� �� ������ ����� � ����������, ��� ������ �� ���������� ����� ��������.</div></span></td>
                      </tr>

                      <tr id="targetblockopen">
                          <td class="centerlink" colspan="3" onclick="javascript:targetopen();">������� ����������� ����� ������� ���������&nbsp;&nbsp;(+ 0.100 ���.)</td>
                      </tr>
                  </tbody>
              </table>

              
              <center>
                  <p>
                      <a href="/tos.php#p3" target="_blank">�������� ������� (������ ��������� � ����� ����)</a><br>
                      <input name="tosaccept" value="1" type="checkbox">� ��������(��) � ��������� ���������� ������� �� SEO sprint
                  </p>
                  <input type="submit" class="button-green" title="���������� ����" value="���������">
              </center>


</form>

{/strip}