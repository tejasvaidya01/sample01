<?php
// bootstrap.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);
error_log(__FILE__);

// jquery 1.12.4 works

class Themes_Bootstrap_View extends View
{
    public function css() : string
    {
error_log(__METHOD__);

        return '
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,300italic" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <style>
* { transition: 0.2s linear; }
body {
  font-family: "Roboto", sans-serif;
  font-size: 17px;
  font-weight: 300;
}
footer { text-align: center; padding: 1em; }
.navbar { margin-bottom: 1rem; }
.table td { white-space: nowrap; }
.delete { color: #ffbfbf; }
.rename { color: #bfbfff; }
.download { color: #bfffbf; }
.is_dir .download{ visibility: hidden; }
.upload input[type="file"] { display: inline-block; }
.upload {
  border-radius: 4px;
  border: 1px solid #dfdfdf;
  box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
  color: rgb(85, 85, 85);
  font-size: 14px;
  padding: 0.25em 0.75em;
}
.breadcrumb { margin-bottom: 0; }
#file_drop_target.drag_over div.upload { background-color: #96C4EA; }
#upload_progress { padding: 4px 0; }
#upload_progress .error { color: #a00; }
#upload_progress > div { padding: 3px 0; }
.no_write #mkdir, .no_write #file_drop_target { display: none; }
.progress_track { display: inline-block; width: 200px; height: 10px; border: 1px solid #333; margin: 0 4px 0 10px;}
.progress { background-color: #82CFFA; height: 10px; }

/*
@media(min-width:767px){
  .alert { margin-top: 1em; }
  .demo-content {
    border-radius: 0.2em;
    box-shadow: 0px 4px 5px 0px rgba(0, 0, 0, 0.14), 0px 1px 10px 0px rgba(0, 0, 0, 0.12), 0px 2px 4px -1px rgba(0, 0, 0, 0.2);
  }
}
*/
</style>';
    }

    public function log() : string
    {
error_log(__METHOD__);

        list($lvl, $msg) = $this->g->in['l']
            ? explode(':', $this->g->in['l']) : util::log();
        return $msg ? '
      <div class="alert alert-'.$lvl.'">'.$msg.'
      </div>' : '';
    }

    public function head() : string
    {
error_log(__METHOD__);

        return '
    <header class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="' . $this->g->self . '"><b>' . $this->g->out['head'] . '</b></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">' . $this->g->out['nav1'] . '
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-align-justify fa-fw"></i> Themes <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">' . $this->g->out['nav2'] . '
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </header>';
    }

    public function nav1(array $a = []) : string
    {
error_log(__METHOD__);

        $a = isset($a[0]) ? $a : util::which_usr($this->g->nav1);
//        $o = '?o='.$_SESSION['o'];
        $o = '?o=' . $this->g->in['o'];
        $t = '?t=' . $_SESSION['t'];
        return join('', array_map(function ($n) use ($o, $t) {
            $c = $o === $n[1] || $t === $n[1] ? ' class="active"' : '';
            $i = isset($n[2]) ? '<i class="' . $n[2] . '"></i> ' : '';
            return '
            <li' . $c . '><a href="' . $n[1] . '">' . $i . $n[0] . '</a></li>';
        }, $a));
    }

    public function nav2() : string
    {
error_log(__METHOD__);

        return $this->nav1($this->g->nav2);
    }

    public function main() : string
    {
error_log(__METHOD__);

        return '
    <main class="container">
      <div class="row">
        <div class="col-md-12">' . $this->g->out['log'] . $this->g->out['main'] . '
        </div>
      </div>
    </main>';
    }

    public function end() : string
    {
error_log(__METHOD__);

        return '
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';
    }

    public function veto_a($href, $label, $class, $extra)
    {
error_log(__METHOD__);

        $class = $class ? ' btn-' . $class : '';
        return ['class' => 'btn btn-primary' . $class];
    }

    public function veto_button($label, $type, $class, $name, $value, $extra)
    {
error_log(__METHOD__);

        $class = $class ? ' btn-' . $class : '';
        return ['class' => 'btn btn-primary' . $class];
    }

    public function email_contact_form()
    {
error_log(__METHOD__);

        return '
      <form class="form-horizontal" role="form" method="post" onsubmit="return mailform(this);">
        <div class="form-group">
          <label for="subject" class="col-sm-2 col-md-3 col-lg-4 control-label">Subject</label>
          <div class="col-sm-9 col-md-7 col-lg-5">
            <input type="text" class="form-control" id="subject" placeholder="Your Subject" required>
          </div>
        </div>
        <div class="form-group">
          <label for="message" class="col-sm-2 col-md-3 col-lg-4 control-label">Message</label>
          <div class="col-sm-9 col-md-7 col-lg-5">
            <textarea class="form-control" id="message" rows="9" placeholder="Your Message" required></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-2 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">
            <input class="btn btn-primary" id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
          </div>
        </div>
      </form>';
    }

    // Notes

    public function notes_item(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        return '
      <table class="table">
        <tr>
          <td><a href="?o=notes&m=read&i=' . $id . '">' . $title . '</a></td>
          <td style="text-align:right">
            <small>
              by <b>' . $author . '</b> - <i>' . util::now($updated) . '</i> -
              <a href="?o=notes&m=update&i=' . $id . '" title="Update">E</a>
              <a href="?o=notes&m=delete&i=' . $id . '" title="Delete" onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')">X</a>
            </small>
          </td>
        </tr>
        <tr>
          <td colspan="2">' . nl2br($content) . '</td>
        </tr>
      </table>';
    }

    public function notes_form(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        return '
      <form class="form-horizontal" role="form" method="post"">
        <div class="form-group">
          <label for="title" class="col-sm-2 col-md-3 col-lg-4 control-label">Title</label>
          <div class="col-sm-9 col-md-7 col-lg-5">
            <input type="text" class="form-control" id="title" name="title" placeholder="Your Title" value="' . $title . '" required>
          </div>
        </div>
        <div class="form-group">
          <label for="author" class="col-sm-2 col-md-3 col-lg-4 control-label">Author</label>
          <div class="col-sm-9 col-md-7 col-lg-5">
            <input type="text" class="form-control" id="author" name="author" placeholder="Authors name" value="' . $author . '" required>
          </div>
        </div>
        <div class="form-group">
          <label for="content" class="col-sm-2 col-md-3 col-lg-4 control-label">Content</label>
          <div class="col-sm-9 col-md-7 col-lg-5">
            <textarea class="form-control" id="content" name="content" rows="9" placeholder="Your Message" required>' . $content . '</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-2 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">' . $this->button('Submit', 'submit', 'primary') . '
          </div>
        </div>
        <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
        <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
        <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
      </form>';
    }

    public function notes_list(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        $buf = '';
        foreach ($notes as $note) $buf .= $this->notes_list_row($note);
        return '
      <div class="responsive">
        <table class="table table-hover table-sm">' . $buf . '
        </table>
      </div>';
    }

    function notes_list_row(array $ary) : string
    {
        extract($ary);
        return '
        <tr>
          <td><a href="?o=notes&m=read&i=' . $id . '">' . $title . '</a></td>
          <td style="text-align:right">
            <small>
              by <b>' . $author . '</b> - <i>' . util::now($updated) . '</i> -
              <a href="?o=notes&m=update&i=' . $id . '" title="Update">E</a>
              <a href="?o=notes&m=delete&i=' . $id . '" title="Delete" onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')">X</a>
            </small>
          </td>
        </tr>
        <tr>
          <td colspan="2"><p>' . nl2br($content) . '</p></td>
        </tr>';
    }
    // Users

    public function users_list(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        $buf = '';
        foreach ($users as $user) $buf .= $this->users_list_row($user);
        return '
      <div class="responsive">
        <table class="table table-hover table-sm">
          <tr><th>UID</th><th>First Name</th><th>Last Name</th><th>Alt Email</th><th></th></tr>' . $buf . '
        </table>
      </div>';
    }

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

    public function users_item(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        return '
      <form class="form-horizontal" role="form" method="post"">
        <div class="form-group">
          <label class="col-sm-2 col-sm-offset-3 control-label">ID</label>
          <p class="form-control-static col-sm-4">' . $id . '</p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-offset-3 control-label">UID</label>
          <p class="form-control-static col-sm-4">' . $uid . '</p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-offset-3 control-label">First Name</label>
          <p class="form-control-static col-sm-4">' . $fname . '</p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-offset-3 control-label">Last Name</label>
          <p class="form-control-static col-sm-4">' . $lname . '</p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-offset-3 control-label">Alt Email</label>
          <p class="form-control-static col-sm-4">' . $altemail . '</p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-offset-3 control-label">Updated</label>
          <p class="form-control-static col-sm-4">' . $updated . '</p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-offset-3 control-label">Created</label>
          <p class="form-control-static col-sm-4">' . $created . '</p>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-offset-3 control-label">Note</label></div>
          <p class="form-control-static col-sm-4"><em>' . nl2br($anote) . '</em></p>
        </div>
        <div class="form-group col-sm-6 col-sm-offset-3 text-right">
          '.$this->a('?o=users&m=update&i='.$id, 'Edit', 'btn btn-primary').'
          '.$this->a('?o=users&m=delete&i='.$id, 'Delete', 'btn btn-danger', ' onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')"').'
        </div>
      </form>';
    }

    public function users_form(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        return '
      <form class="form-horizontal" role="form" method="post"">
        <div class="form-group">
          <label for="uid" class="control-label col-sm-2 col-sm-offset-3">UID</label>
          <div class="col-sm-4">
            <input type="email" class="form-control" id="uid" name="uid" placeholder="User ID (email)" value="' . $uid . '" required>
          </div>
        </div>
        <div class="form-group">
          <label for="fname" class="control-label col-sm-2 col-sm-offset-3">First Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="' . $fname . '" required>
          </div>
        </div>
        <div class="form-group">
          <label for="lname" class="control-label col-sm-2 col-sm-offset-3">Last Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="' . $lname . '" required>
          </div>
        </div>
        <div class="form-group">
          <label for="altemail" class="control-label col-sm-2 col-sm-offset-3">Alt Email</label>
          <div class="col-sm-4">
            <input type="email" class="form-control" id="altemail" name="altemail" placeholder="Alternate Email Address" value="' . $altemail . '" required>
          </div>
        </div>
        <div class="form-group">
          <label for="anote" class="control-label col-sm-2 col-sm-offset-3">Note</label>
          <div class="col-sm-4">
            <textarea class="form-control" id="anote" name="anote" rows="3" placeholder="Admin Note">' . $anote . '</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6 col-sm-offset-3 text-right">'
            .$this->button('Save', 'submit', 'primary').'
          </div>
        </div>
       <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
      </form>';
    }

    // Auth

//    public function auth_signin(string $uid = '') : string
    public function auth_signin(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        return '
        <h2><i class="fa fa-sign-in fa-fw"></i> Sign in</h2>
        <div class="col-md-4 col-md-offset-4">
          <form class="form" role="form" action="" method="post">
            <input type="hidden" name="o" value="auth">
            <div class="row">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-user fa-fw"></span></span>
                  <input type="text" name="uid" id="uid" class="form-control" placeholder="Your Email Address" value="'.$uid.'" required autofocus>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><span class="fa fa-key fa-fw"></span></span>
                  <input type="password" name="webpw" id="webpw" class="form-control" placeholder="Your Password">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember" id="remember" value="yes"> Remember me on this computer
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <div class="text-right">
                  <a class="btn btn-md btn-default" href="?o=auth&amp;m=forgotpw">Forgot password</a>
                  <button class="btn btn-md btn-primary" type="submit" name="a" value="signin">Sign in</button>
                </div>
              </div>
            </div>
          </form>
        </div>';
    }

//    public function auth_forgotpw(string $uid = '') : string
    public function auth_forgotpw(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        return '
        <h2><i class="fa fa-key fa-fw"></i> Reset password</h2>
        <div class="col-md-4 col-md-offset-4">
          <form class="form" role="form" action="?o=auth&amp;m=forgotpw" method="post">
            <input type="hidden" name="o" value="auth">
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
                  <a class="btn btn-md btn-default" href="?o=auth&amp;m=signin">&laquo; Back</a>
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

        return '
        <h2><i class="fa fa-key fa-fw"></i> Reset Password</h2>
        <div class="col-md-4 col-md-offset-4">
          <form class="form" role="form" action="?o=auth&amp;m=resetpw" method="post">
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
}
