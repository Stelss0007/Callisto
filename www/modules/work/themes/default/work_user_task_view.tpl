{strip}
<h1>����� ������������ �� ���������� �������</h1>
����������� �������� � ����� �������� ���������� � ���������� �������.
������������� ����� ����� ��������� ���� ������,
���� ������� ���������� �� ���� ��������� � ������ ����.
������� ��� ��, ��� ���������� ������������ ����,
�� ������� �� ������ ������ ��������� �������.
�� ��������� ����� ����� ������ �� ���������� ������������.
<div class="tskblank4">
  <div class="tskblank3">
    <div class="tskblank2">
      <div class="tskblank1">
        <span class="tskblank-title">
          � {$task.id}: �{$task.displayname}�
          {if 1}
          <div style="float:right;">
            <a href="/index.php?module=work&type=user&func=task_modify&id={$task.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
            <a href="/index.php?module=work&type=user&func=task_delete&id={$task.id}"><img border="0" src="/public/images/system/del.gif" alt="�������"></a>
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
                  <b>����� �������:</b>
                  <br>
                  <a class="tsk-mail" href="/mailnew.php?mailto=268237" target="_blank" title="�������� ������ �������">
                  </a>ID: <a href="/userinfo.php?user=268237">268237 - bredsmith</a>
                  <br>
                  <a class="alltasks" href="/work-task.php?taskuser=268237" target="_blank">���������� ��� ������� ������</a>
                  <br>
                  <table class="tskstat">
                    <tbody>
                      <tr>
                        <td>�������</td>
                        <td>
                          <span class="rating5w" title="������ � �������: ��������">
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td>������ � �������&nbsp;&nbsp;&nbsp;</td>
                        <td>
                          <a class="alltasks" href="/work-task-feed.php?adv=58846&amp;tus=268237&amp;cnt=d6560f8dabea829cf4dcae6df0ef8dac">6 - ���������</a>
                        </td>
                      </tr>
                      <tr>
                        <td>������</td>
                        <td>
                          <span style="color: #C06606;">������������</span>
                        </td>
                      </tr>
                      <tr>
                        <td>���������</td>
                        <td>
                          <span style="color: #34A305;" title="��������">215</span>
                          / <span style="color: #B1051E;" title="���������">5</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
                <td style="vertical-align: top;">
                  <span class="taskprice-note">{$task.currency} <span style="font-size: 12px;">���</span></span>
                  <span class="taskprice">���� ����������</span>
                  <form name="taskfavform" method="post" action="">
                    <input name="cnt" value="6371abc49a91d6676352ec902f1f506e" type="hidden">
                    <input name="adv" value="58846" type="hidden">
                  </form>
                  <span id="t-fail" class="task-fail" title="�� ������ ������ ����� �������!" onclick="senddata(document, 5)" ;="">
                  </span>
                  <span id="t-favout" style="display: none;" class="task-favoriteout" title="��������� ������� �� ����������" onclick="senddata(document, 4)" ;=""></span>
                  <span id="t-fav" class="task-favorite" title="�������� ������� � ���������" onclick="senddata(document, 3)" ;=""></span>
                </td>
              </tr>
            </tbody>
          </table>
          <span class="task-subtitle">�������� �������:</span>
          <span class="taskdescription">
            {$task.description}
          </span>
          <span class="task-subtitle">��� ����� ����� ��� ���������� �������:</span>
          <span class="taskquestion">
            {$task.addinfo}
          </span>

          <span class="task-subtitle">��������!</span>
          <b>�� ���������� ����� ������� ���������� �� ����� 1 ����!</b>
          <br>����� ��������� �������, ������� �� ������ ������� ����������.
          ����������� �������������� ���������� � ���������� ������� ����� ����� ������ ����� ��, �� �������� �������.
          �������!
          <form name="goform" method="post" action="/gotask.php" target="_blank">
            <input name="cnt" value="6371abc49a91d6676352ec902f1f506e" type="hidden">
            <input name="adv" value="58846" type="hidden">
          </form>
          <center>
            <span class="button-green-big" style="margin-top: 10px;" title="���������� � ���������� �������" onclick="javascript:gotask();">������ ����������!</span>
            <span class="desctext">����� ��������� ������� �� ����<br>http://www.cosmo.ru/sp/htc/profile.php?RESULT_ID=323957</span>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>
{/strip}