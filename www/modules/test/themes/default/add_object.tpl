<div class="error" style="color: red; font-weight: bold;">
{$sysMessage}
</div>
<form action="/test/create_object" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td>
        Firstname
      </td>
      <td>
        <input type="text" value="{$firstname}" name="firstname">
      </td>
    </tr>
    <tr>
      <td>
        Lastname
      </td>
      <td>
        <input type="text" value="{$lastname}" name="lastname">
      </td>
    </tr>
    <tr>
      <td>
        Photo
      </td>
      <td>
        <input type="file" value="" name="photo">
      </td>
    </tr>
  </table>
  <input type="submit" value="Save">
</form>