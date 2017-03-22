<?php
// lib/php/themes/simple/users.php 20150101 - 20170306
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_Simple_Users extends Themes_Simple_Theme {

    public function create(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    public function read(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    public function update(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    public function list(array $in) : string
    {
error_log(__METHOD__);

        $buf = '';
        $num = count($in);

        foreach ($in as $a) {
            extract($a);
            $buf .= '
        <tr>
          <td>
            <a href="?o=users&m=read&i=' . $id . '" title="Show user">
              <strong>' . $login . '</strong>
            </a>
          </td>
          <td>' . $fname . '</td>
          <td>' . $lname . '</td>
          <td>' . $altemail . '</td>
          <td>' . $this->g->acl[$acl] . '</td>
        </tr>';
        }

        return '
          <h2><a href="?o=users&m=create" title="Add new user"><b>Users (+)</b></a></h3>
          <table>
            <thead class="nowrap">
              <tr class="bg-primary text-white">
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Alt Email</th>
                <th>ACL</th>
              </tr>
            </thead>
            <tbody>' . $buf . '
            </tbody>
          </table>';
    }

    private function editor(array $in) : string
    {
error_log(__METHOD__);

        extract($in);

        $header = $this->g->in['m'] === 'create' ? 'Add User' : 'Update User';
        $submit = $this->g->in['m'] === 'create' ? '
              <a class="btn" href="?o=users&m=list">&laquo; Back</a>
              <button type="submit" name="m" value="create" class="btn btn-success">Add This Item</button>' : '
              <a class="btn" href="?o=users&m=list">&laquo; Back</a>
              <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $login . '?\')">Remove</a>
              <button type="submit" name="m" value="update" class="btn btn-success">Update</button>';

        return '
          <h2><a href="?o=users&m=list"><b>&laquo; ' . $header . '</b></a></h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <input type="hidden" name="i" value="' . $this->g->in['i'] . '">

            <input type="hidden" name="acl" value="' . $acl . '">
            <input type="hidden" name="webpw" value="' . $webpw . '">
            <p>
              <label for="login">UserID</label><br>
              <input type="email" id="login" name="login" value="' . $login . '" required>
            </p>
            <p>
              <label for="fname">First Name</label><br>
              <input type="text" id="fname" name="fname" value="' . $fname . '" required>
            </p>
            <p>
              <label for="lname">Last Name</label><br>
              <input type="text" id="lname" name="lname" value="' . $lname . '" required>
            </p>
            <p>
              <label for="altemail">Alt Email</label><br>
              <input type="text" id="altemail" name="altemail" value="' . $altemail . '">
            </p>
            <p>
              <label for="password1">Password</label><br>
              <input type="password" name="passwd1" id="passwd1" value="">
            </p>
            <p>
              <label for="password2">Password Repeat</label><br>
              <input type="password" name="passwd2" id="passwd2" value="">
            </p>
            <p>
              <label for="anote">Admin Notes</label><br>
              <textarea rows="9" id="anote" name="anote">' . nl2br($anote) . '</textarea>
            </p>
            <br>
            <p class="text-right">' . $submit . '
            </p>
          </form>';
    }
}

?>
