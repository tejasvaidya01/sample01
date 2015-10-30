<?php
// widgets.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Widgets
{
    public function a(
        string $href,
        string $label = '',
        string $class = '',
        string $extra = '') : string
    {
        $v = 'veto_a';
        if (method_exists($this, $v))
            extract($this->$v($href, $label, $class, $extra));

        $label = $label ?? $href;
        $class = $class ? ' class="'.$class.'"' : '';
        return '
          <a'.$class.' href="'.$href.'"'.$extra.'>'.$label.'</a>';
    }

    public function button(
        string $label,
        string $type = '',
        string $class = '',
        string $name = '',
        string $value = '',
        string $extra = '') : string
    {
        $v = 'veto_button';
        if (method_exists($this, $v))
            extract($this->$v($label, $type, $class, $name, $value, $extra));

        $class = $class ? ' class="'.$class.'"' : '';
        $type  = $type  ? ' type="'.$type.'"'   : '';
        $name  = $type  ? ' name="'.$name.'"'   : '';
        $value = $value ? ' value="'.$value.'"' : '';
        $extra = $extra ?? '';
        return '
          <button'.$class.$type.$name.$value.$extra.'>'.$label.'</button>';
    }
/*
    public function email_contact_form() : string
    {
        $v = 'veto_email_contact_form';
        if (method_exists($this, $v)) return $this->$v();
        return '
      <form action="" method="post" onsubmit="return mailform(this);">
        <p>
          <label for="subject">Your Subject</label>
          <input type="text" id="subject" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,40}$">
        </p>
        <p>
          <label for="message">Your Message</label>
          <textarea type="text" rows= "5" id="message" maxlength="1024" minlength="5"></textarea>
        </p>
        <p>' . $this->button('Send', 'submit', 'primary') . '
        </p>
      </form>';
    }

    // Notes

    public function notes_item($ary) : string
    {
        $v = 'veto_notes_item';
        if (method_exists($this, $v)) return $this->$v($ary);
        extract($ary);
        return '
      <hr>
      <table>
        <tr>
          <td><a href="?p=notes&a=read&i=' . $id . '">' . $title . '</a></td>
          <td style="text-align:right">
            <small>
              by <b>' . $author . '</b> - <i>' . util::now($updated) . '</i> -
              <a href="?p=notes&a=update&i=' . $id . '" title="Update">E</a>
              <a href="?p=notes&a=delete&i=' . $id . '" title="Delete" onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')">X</a>
            </small>
          </td>
        </tr>
        <tr>
          <td colspan="2">' . nl2br($content) . '</td>
        </tr>
      </table>
      <br>';
    }

    public function notes_form($ary) : string
    {
        $v = 'veto_notes_form';
        if (method_exists($this, $v)) return $this->$v($ary);
        extract($ary);
        return '
      <form action="" method="POST">
        <p>
          <label for="title">Title</label>
          <input type="text" name="title" id="title" value="' . $title . '">
        </p>
        <p>
          <label for="author">Author</label>
          <input type="text" name="author" id="author" value="' . $author . '">
        </p>
        <p>
          <label for="content">Note</label>
          <textarea rows="7" name="content" id="content">' . $content . '</textarea>
        </p>
        <p>' . $this->button('Submit', 'submit', 'primary') . '</p>
        <input type="hidden" name="p" value="' . $this->g->in['p'] . '">
        <input type="hidden" name="a" value="' . $this->g->in['a'] . '">
        <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
      </form>';
    }
*/
    // Users
/*
    public function users_list(string $str) : string
    {
        $v = 'veto_users_list';
        if (method_exists($this, $v)) return $this->$v($str);
        return '
      <table>' . $str . '
      </table>';
    }

    public function users_list_row(array $ary) : string
    {
        $v = 'veto_users_list_row';
        if (method_exists($this, $v)) return $this->$v($ary);
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

    public function users_item(array $ary) : string
    {
        $v = 'veto_users_item';
        if (method_exists($this, $v)) return $this->$v($ary);
        extract($ary);
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
    }

    public function users_form(array $ary) : string
    {
        $v = 'veto_users_form';
        if (method_exists($this, $v)) return $this->$v($ary);
        extract($ary);
        return '
      <form action="" method="POST">
        <p>
          <label for="uid">UID</label>
          <input type="text" id="uid" name="uid" value="' . $uid . '">
        </p>
        <p>
          <label for="fname">FirstName</label>
          <input type="text" id="fname" name="fname" value="' . $fname . '">
        </p>
        <p>
          <label for="lname">LastName</label>
          <input type="text" id="lname" name="lname" value="' . $lname . '">
        </p>
        <p>
          <label for="email">Email</label>
          <input type="text" id="email" name="email" value="' . $email . '">
        </p>
        <p>
          <label for="anote">Note</label>
          <textarea rows="3" name="anote" id="anote">' . $anote . '</textarea>
        </p>
        <p>' . $this->button('Submit', 'submit', 'primary') . '
        <input type="hidden" name="p" value="' . $this->g->in['p'] . '">
        <input type="hidden" name="a" value="' . $this->g->in['a'] . '">
        <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
      </form>';
    }
*/
    // Auth
/*
    public function auth_signin(string $uid = '') : string
    {
error_log(__METHOD__);

        $v = 'veto_auth_signin';
        if (method_exists($this, $v)) return $this->$v($uid);
        return '
      <h2>Sign in</h2>
      <form class="form" role="form" action="" method="post">
        <input type="hidden" name="p" value="auth">
        <p>
          <label for="uid">Login ID</label>
          <input type="text" name="uid" id="uid" placeholder="Your Email Address" value="' . $uid  . '" required autofocus>
        </p>
        <p>
          <label for="uid">Password</label>
          <input type="password" name="webpw" id="webpw" placeholder="Your Password">
        </p>
        <p>
          <input type="checkbox" name="remember" id="remember" value="yes"> Remember me on this computer
        </p>
        <p>' . $this->a('?p=auth&amp;a=forgotpw', 'Forgot password')
             . $this->button('Log me in', 'submit', 'primary') . '
        </p>
      </form>';
    }

    public function auth_forgotpw(string $uid = '') : string
    {
error_log(__METHOD__);

        $v = 'veto_auth_forgotpw';
        if (method_exists($this, $v)) return $this->$v($uid);
        return '
        <h2>Reset password</h2>
        <div class="col-md-6 col-md-offset-3">
          <form class="form" role="form" action="?p=auth&amp;a=forgotpw" method="post">
            <input type="hidden" name="p" value="auth">
            <div class="row">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-envelope fa-fw"></span></span>
                  <input type="email" name="uid" id="uid" class="form-control" placeholder="Your Login Email Address" value="'.$uid.'" required autofocus>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <div class="text-right">
                  <a class="btn btn-md btn-default" href="?p=auth&amp;a=signin">&laquo; Back</a>
                  <button class="btn btn-md btn-primary" type="submit">Send</button>
                </div>
              </div>
            </div>
            <div class="row text-center">
              You will receive an email with further instructions and please
              note that this only resets the password for this website interface.
            </div>
          </form>
        </div>';
    }

    public function auth_newpw(int $id, string $uid) : string
    {
error_log(__METHOD__." id=".$id);

        $v = 'veto_auth_newpw';
        if (method_exists($this, $v)) return $this->$v($id, $uid);
        return '
        <h2><i class="fa fa-key fa-fw"></i> Reset Password</h2>
        <div class="col-md-6 col-md-offset-3">
          <form class="form" role="form" action="?p=auth&amp;a=resetpw" method="post">
            <input type="hidden" name="i" value="'.$id.'">
            <div class="row">
              <p class="text-center"><b>'.$uid.'</b></p>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key fa-fw"></span></span>
                  <input type="password" name="passwd1" id="passwd1" class="form-control" placeholder="New Password" value="" required autofocus>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key fa-fw"></span></span>
                  <input type="password" name="passwd2" id="passwd2" class="form-control" placeholder="Confirm Password" required value="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <div class="text-right">
                  <button class="btn btn-md btn-primary" type="submit">Reset my password</button>
                </div>
              </div>
            </div>
          </form>
        </div>';
    }
*/
}
