{strip}
      {if $blockinfo.position=='c' or $blockinfo.position=='t' or $blockinfo.position=='b'}

<form name="search" action="index.php" method="get">
  <input type="hidden" name="module" value="search">
  <input type="hidden" name="func" value="view">

  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="10%">
      <col width="90%">
    </colgroup>

    <tbody>
      <tr>
        <td class="head" align="right">Я ищу:</td>
        <td class="even">
         <input maxLength="255" size="80" name="search_string">&nbsp;&nbsp;
         <input class="formButton" type="submit" value="Искать" name="submit">
        </td>
      </tr>
    </tbody>

  </table>
</form>

      {else}
      <form name="search" action="index.php" method="get" style="margin: 0;">
        <input type="hidden" name="module" value="search">
        <input type="hidden" name="func" value="view">
        <table cellSpacing="0" cellPadding="1" width="100%" border="0">
            <tr>
              <td align="center">
                <input maxLength="255" size="14" name="search_string">
              </td>
            </tr>
            <tr>
              <td align="center">
                <input type="submit" value="Искать">
              </td>
            </tr>
        </table>
      </form>

      {/if}
{/strip}