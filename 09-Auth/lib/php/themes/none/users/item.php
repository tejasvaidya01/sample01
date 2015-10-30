<?php

return '
      <hr>
      <table style="table-layout: fixed">
        <tr><td></td><td>ID:</td><td>' . $id . '</td><td></td></tr>
        <tr><td></td><td>UID:</td><td>' . $uid . '</td><td></td></tr>
        <tr><td></td><td>FirstName:</td><td>' . $fname . '</td><td></td></tr>
        <tr><td></td><td>LastName:</td><td>' . $lname . '</td><td></td></tr>
        <tr><td></td><td>Email:</td><td>' . $email . '</td><td></td></tr>
        <tr><td></td><td>Created:</td><td>' . $created . '</td><td></td></tr>
        <tr><td></td><td>Updated:</td><td>' . $updated . '</td><td></td></tr>
        <tr><td></td><td colspan="2"><p><em>' . nl2br($anote) . '</em></p></td><td></td></tr>
        <tr><td></td>
          <td colspan="2" style="text-align:center">
            <p>
            '.$this->a('?p=users&a=update&i='.$id, 'Edit', 'btn').'
            '.$this->a('?p=users&a=delete&i='.$id, 'Delete', 'btn danger', ' onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')"').'
            </p>
          </td>
        </tr>
      </table>';
