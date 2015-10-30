<?php

$buf = '';
foreach ($users as $user) $buf .= users_list_row($user);
return '
      <table>' . $buf . '
      </table>';

    function users_list_row(array $ary) : string
    {
        extract($ary);
        return '
        <tr>
          <td><a href="?p=users&a=read&i=' . $id . '">' . $uid . '</a></td>
          <td>' . $fname . '</td>
          <td>' . $lname . '</td>
          <td>' . $email . '</td>
          <td style="text-align:right">
            <small>
              <a href="?p=users&a=update&i=' . $id . '" title="Update">E</a>
              <a href="?p=users&a=delete&i=' . $id . '" title="Delete" onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')">X</a>
            </small>
          </td>
        </tr>';
    }

