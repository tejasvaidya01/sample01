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
            <a href="?o=users&m=read&i=' . $id . '" title="Show user">
              <strong>' . $userid . '</strong>
            </a>
          </td>
          <td>' . $fname . '</td>
          <td>' . $lname . '</td>
          <td>' . $altemail . '</td>
          <td>' . $this->g->acl[$acl] . '</td>
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
/*
        extract($in);

        return '
          <h3 class="w30">
            <a href="?o=users&m=read&i=0">
              <i class="fa fa-users fa-fw"></i> ' . $userid . '
            </a>
            <small>&nbsp;ID: ' . $id . '</small>
          </h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>UserID:</b></label>
                  <p class="form-control-static col-sm-8"><a href="mailto:' . $userid . '">' . $userid . '</a></p>
                </div>
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>Full Name:</b></label>
                  <p class="form-control-static col-sm-8">' . $fname . ' ' . $lname . '</p>
                </div>
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>ACL:</b></label>
                  <p class="form-control-static col-sm-8">' . $this->g->acl[$acl] . '</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>Alt Email:</b></label>
                  <p class="form-control-static col-sm-8"><a href="mailto:' . $altemail . '">' . $altemail . '</a></p>
                </div>

                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>Updated:</b></label>
                  <p class="form-control-static col-sm-8">' . $updated . '</p>
                </div>
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>Created:</b></label>
                  <p class="form-control-static col-sm-8">' . $created . '</p>
                </div>
              </div>
              <div class="col-md-4">
              <div class="row">
                <textarea rows="4" class="form-control" placeholder="Admin notes" disabled>' . nl2br($anote) . '</textarea>
              </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-right">
                <div class="btn-group">
                  <a class="btn btn-secondary" href="?o=users&m=read&i=0">&laquo; Back</a>
                  <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $userid . '?\')">Remove</a>
                  <a class="btn btn-primary" href="?o=users&m=update&i=' . $id . '">Update</a>
                </div>
              </div>
            </div>
          </form>';
*/
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

//        $itemid = $this->g->in['m'] === 'create' ? 0 : $id;
        $header = $this->g->in['m'] === 'create' ? 'Add User' : 'Update User';
        $submit = $this->g->in['m'] === 'create' ? '
                <a class="btn btn-outline-primary" href="?o=users&m=read&i=0">&laquo; Back</a>
                <button type="submit" name="m" value="create" class="btn btn-primary">Add This Item</button>' : '
                <a class="btn btn-outline-primary" href="?o=users&m=read&i=0">&laquo; Back</a>
                <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $userid . '?\')">Remove</a>
                <button type="submit" name="m" value="update" class="btn btn-primary">Update</button>';

        return '
          <h3 class="w30">
            <a href="?o=users&m=read&i=0">
              <i class="fa fa-users fa-fw"></i> ' . $header . '
            </a>
          </h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <input type="hidden" name="i" value="' . $this->g->in['i'] . '">

            <input type="hidden" name="acl" value="' . $acl . '">
            <input type="hidden" name="webpw" value="' . $webpw . '">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="userid">UserID</label>
                  <input type="email" class="form-control" id="userid" name="userid" value="' . $userid . '" required>
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
                  <label for="password1">Password</label>
                  <input type="password" class="form-control" name="passwd1" id="passwd1" value="">
                </div>
                <div class="form-group">
                  <label for="password2">Password Repeat</label>
                  <input type="password" class="form-control" name="passwd2" id="passwd2" value="">
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
              <div class="col-md-12">
                <div class="btn-group pull-right">' . $submit . '
                </div>
              </div>
            </div>
          </form>';
    }
}

?>
