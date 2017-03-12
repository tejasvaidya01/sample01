<?php
// lib/php/themes/bootstrap/users.php 20170225
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_Bootstrap_Users extends Themes_Bootstrap_Theme
{
    public function create(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    public function read(array $in) : string
    {
error_log(__METHOD__);

        $buf = '';
        $num = count($in);

        foreach ($in as $a) {
            extract($a);
            $buf .= '
        <tr>
          <td>
            <a href="?o=users&m=read&i=' . $id . '" title="Show user: ' . $id . '">
              <strong>' . $login . '</strong>
            </a>
          </td>
          <td>' . $fname . '</td>
          <td>' . $lname . '</td>
          <td>' . $altemail . '</td>
          <td>' . $this->g->acl[$acl] . '</td>
          <td>' . $grp . '</td>
        </tr>';
        }

        return '
          <h3 class="min60">
            <a href="?o=users&m=create" title="Add new user">
              <i class="fa fa-users fa-fw"></i> Users
              <small>
                <i class="fa fa-plus-circle fa-fw"></i>
                <span class="badge badge-pill badge-default pull-right">' . $num . '</span>
              </small>
            </a>
          </h3>
          <div class="table-responsive">
            <table class="table table-sm min600">
              <thead class="nowrap">
                <tr class="bg-primary text-white">
                  <th>User ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Alt Email</th>
                  <th>ACL</th>
                  <th>Grp</th>
                </tr>
              </thead>
              <tbody>' . $buf . '
              </tbody>
            </table>
          </div>';
    }

    public function read_one(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    public function update(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    private function editor(array $in) : string
    {
error_log(__METHOD__);
error_log(var_export($in,true));

        extract($in);
        $ary1 = $ary2 = [];
        foreach($this->g->acl as $k => $v) $ary1[] = [$v, $k];

        $res = db::qry("
 SELECT login,id FROM `users`
  WHERE acl = :0 OR acl = :1", ['0' => 0, "1" => 1]);

        foreach($res as $k => $v) $ary2[] = [$v['login'], $v['id']];

        $acl = null ?? '2';
        $grp = null ?? '';
        
        $aclbuf = $this->dropdown($ary1, 'acl', $acl, '', 'custom-select');
        $grpbuf = $this->dropdown($ary2, 'grp', $grp, '', 'custom-select');

        $header = $this->g->in['m'] === 'create' ? 'Add User' : 'Update User';
        $submit = $this->g->in['m'] === 'create' ? '
                <a class="btn btn-outline-primary" href="?o=users&m=read">&laquo; Back</a>
                <button type="submit" name="m" value="create" class="btn btn-primary">Add This Item</button>' : '
                <a class="btn btn-outline-primary" href="?o=users&m=read">&laquo; Back</a>
                <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $login . '?\')">Remove</a>
                <button type="submit" name="m" value="update" class="btn btn-primary">Update</button>';

        $switch_buf = '';
        if ($this->g->in['m'] !== 'create')
            if (util::is_adm() && (util::is_acl(0) or util::is_acl(1))) $switch_buf = '
                  <a class="btn btn-outline-primary pull-left" href="?o=users&m=switch_user&i=' . $id . '">Switch to ' . $login . '</a>';

        return '
          <h3 class="w30">
            <a href="?o=users&m=read">
              <i class="fa fa-users fa-fw"></i> ' . $header . '
            </a>
          </h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="i" value="' . $id . '">
            <input type="hidden" name="webpw" value="' . $webpw . '">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="login">UserID</label>
                  <input type="email" class="form-control" id="login" name="login" value="' . $login . '" required>
                </div>
                <div class="form-group">
                  <label for="fname">First Name</label>
                  <input type="text" class="form-control" id="fname" name="fname" value="' . $fname . '" required>
                </div>
                <div class="form-group">
                  <label for="lname">Last Name</label>
                  <input type="text" class="form-control" id="lname" name="lname" value="' . $lname . '" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="altemail">Alt Email</label>
                  <input type="text" class="form-control" id="altemail" name="altemail" value="' . $altemail . '">
                </div>
                <div class="form-group">
                  <label for="acl">ACL</label><br>' . $aclbuf . '
                </div>
                <div class="form-group">
                  <label for="grp">Group</label><br>' . $grpbuf . '
                </div>
<!--
                <div class="form-group">
                  <label for="password1">Password</label>
                  <input type="password" class="form-control" name="passwd1" id="passwd1" value="">
                </div>
                <div class="form-group">
                  <label for="password2">Password Repeat</label>
                  <input type="password" class="form-control" name="passwd2" id="passwd2" value="">
                </div>
-->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="anote">Admin Notes</label>
                  <textarea rows="9" class="form-control" id="anote" name="anote">' . nl2br($anote) . '</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">' . $switch_buf . '
                <div class="btn-group pull-right">' . $submit . '
                </div>
              </div>
            </div>
          </form>';
    }
}

?>
