<?php
// users/list.php 20151030 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

$buf = '';
foreach ($users as $user) $buf .= users_list_row($user);
return '
      <table>
        <tr><th>UID</th><th>FirstName</th><th>LastName</th><th>Alt Email</th><th></th></tr>' . $buf . '
      </table>';

    function users_list_row(array $ary) : string
    {
        extract($ary);
        return '
        <tr>
          <td><a href="?o=users&m=read&i=' . $id . '">' . $uid . '</a></td>
          <td>' . $fname . '</td>
          <td>' . $lname . '</td>
          <td>' . $altemail . '</td>
          <td style="text-align:right">
            <small>
              <a href="?o=users&m=update&i=' . $id . '" title="Update">E</a>
              <a href="?o=users&m=delete&i=' . $id . '" title="Delete" onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')">X</a>
            </small>
          </td>
        </tr>';
    }

