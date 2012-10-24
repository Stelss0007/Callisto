<div class="error" style="color: red; font-weight: bold;">
{$sysMessage}
</div>

<form method="post" action='/index.php?module=test&action=valid'>
  <table>
    <col style="text-align: right;">
    <col>
    <tr>
      <td>
        *First Name: 
      </td>
      <td>
        <input type="text" name="firstname[]" value="{$firstname.0}" maxlength="80" />
      </td>
    </tr>
    <tr>
      <td>
        *First Name2:
      </td>
      <td>
        <input type="text" name="firstname[]" value="{$firstname.1}" maxlength="80" />
      </td>
    </tr>
    <tr>
      <td>
        *Last Name:
      </td>
      <td>
        <input type="text" name="lastname" value="{$lastname}" maxlength="80" />
      </td>
    </tr>
    <tr>
      <td>
        Mobile: 
      </td>
      <td>
        <input type="text" name="mobile" value="{$mobile}" />
      </td>
    </tr>
    <tr>
      <td>
        *Email: 
      </td>
      <td>
        <input type="text" name="email" value="{$email}" />
      </td>
    </tr>
    <tr>
      <td>
        Comment: 
      </td>
      <td>
        <textarea name="comment">{$comment}</textarea>
      </td>
    </tr>
  </table>

  <p><input type="checkbox" name="t-and-c" id="t-and-c" value="true" /> </p>

  <p><strong>* Required</strong></p>

  <p><input type="submit" value="Send" /></p>

</form>