<?php
// lib/php/themes/bootstrap/users.php 20170225 - 20170317
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

        $buf = $pgr_top = $pgr_end = '';
        $pgr = $in['pager']; unset($in['pager']);
        $num = count($in);

        if ($pgr['last'] > 1) {
            $pgr_top ='
          <div class="col-md-6">' . $this->pager($pgr) . '
          </div>';
            $pgr_end = '
          <div class="row">
            <div class="col-12">' . $this->pager($pgr) . '
            </div>
          </div>';
        }

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
        <div class="row">
          <div class="col-md-6">
            <h3 class="min60">
              <a href="?o=users&m=create" title="Add new user">
                <i class="fa fa-users fa-fw"></i> Users
                <small><i class="fa fa-plus-circle fa-fw"></i></small>
              </a>
            </h3>
          </div>' . $pgr_top . '
        </div>
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
        </div>' . $pgr_end;
    }

    private function editor(array $in) : string
    {
error_log(__METHOD__);
error_log(var_export($in, true));

        extract($in);

        if ($this->g->in['m'] === 'create') {
            $header = 'Add User';
            $switch = '';
            $submit = '
                <a class="btn btn-outline-primary" href="?o=users&m=list">&laquo; Back</a>
                <button type="submit" name="m" value="create" class="btn btn-primary">Add This Item</button>';
        } else {
            $header = 'Update User';
error_log("is_usr($id) = ".var_export(!util::is_usr($id),true));
            $switch = !util::is_usr($id) && (util::is_acl(0) || util::is_acl(1)) ? '
                  <a class="btn btn-outline-primary pull-left" href="?o=users&m=switch_user&i=' . $id . '">Switch to ' . $login . '</a>' : '';
            $submit = '
                <a class="btn btn-outline-primary" href="?o=users&m=list">&laquo; Back</a>
                <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $login . '?\')">Remove</a>
                <button type="submit" name="m" value="update" class="btn btn-primary">Update</button>';
        }

        $acl_ary = $grp_ary = [];

        foreach($this->g->acl as $k => $v) $acl_ary[] = [$v, $k];
        $acl_buf = $this->dropdown($acl_ary, 'acl', $acl, '', 'custom-select');

        $res = db::qry("
 SELECT login,id FROM `users`
  WHERE acl = :0 OR acl = :1", ['0' => 0, "1" => 1]);

        foreach($res as $k => $v) $grp_ary[] = [$v['login'], $v['id']];
        $grp_buf = $this->dropdown($grp_ary, 'grp', $grp, '', 'custom-select');

        return '
          <h3 class="min600">
            <a href="?o=users&m=list">
              <i class="fa fa-users fa-fw"></i> ' . $header . '
            </a>
          </h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="i" value="' . $id . '">
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
                  <label for="acl">ACL</label><br>' . $acl_buf . '
                </div>
                <div class="form-group">
                  <label for="grp">Group</label><br>' . $grp_buf . '
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="anote">Admin Notes</label>
                  <textarea rows="9" class="form-control" id="anote" name="anote">' . nl2br($anote) . '</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">' . $switch . '
                <div class="btn-group pull-right">' . $submit . '
                </div>
              </div>
            </div>
          </form>';
    }
}

?>
