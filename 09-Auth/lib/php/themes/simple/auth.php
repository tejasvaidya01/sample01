<?php
// lib/php/themes/simple/auth.php 20150101 - 20170307
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_Simple_Auth extends Themes_Simple_Theme
{
    // forgotpw (create new pw)
    public function create(array $in) : string
    {
error_log(__METHOD__);

        extract($in);

        return '
          <h2><b>Forgot password</b></h2>
          <form action="' . $this->g->self . '" method="post">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <p>
              <input type="email" name="userid" placeholder="Your Login Email Address" value="' . $userid . '" autofocus required>
            </p>
            <p class="text-center">
              <small>
                You will receive an email with further instructions and please
                note that this only resets the password for this website interface.
              </small>
            </p>
            <p class="text-right">
              <a class="btn" href="?o=auth">&laquo; Back</a>
              <button class="btn btn-success" type="submit" name="m" value="create">Send</button>
            </p>
          </form>';
    }

    // signin (read current pw)
    public function read(array $in) : string
    {
error_log(__METHOD__);

        extract($in);

        return '
          <h2><b>Sign in</b></h2>
          <form action="' . $this->g->self . '" method="post">
            <input type="hidden" name="o" value="auth">
            <p>
              <input type="email" name="userid" placeholder="Your Email Address" value="'.$userid.'" required autofocus>
            </p>
            <p>
              <input type="password" name="webpw" placeholder="Your Password" required>
            </p>
            <p>
              <input type="checkbox" name="remember" value="yes">
              <span>Remember me on this computer</span>
            </p>
            <p class="text-right">
              <a class="btn" href="?o=auth&m=create">Forgot password</a>
              <button class="btn btn-success" type="submit" name="m" value="read">Sign in</button>
            </p>
          </form>';
    }

    // resetpw (update pw)
    public function update(array $in) : string
    {
error_log(__METHOD__);

        extract($in);

        return '
          <h2><b>Update Password</b></h2>
          <form action="' . $this->g->self . '" method="post">
            <input type="hidden" name="o" value="auth">
            <input type="hidden" name="id" value="' . $id . '">
            <input type="hidden" name="userid" value="' . $userid . '">
            <p class="text-center"><b>For ' . $userid . '</b></p>
            <p>
              <input type="password" name="passwd1" placeholder="New Password" required autofocus>
            </p>
            <p>
              <input type="password" name="passwd2" placeholder="Confirm Password" required>
            </p>
            <p class="text-right">
              <button class="btn btn-success" type="submit" name="m" value="update">Update my password</button>
            </p>
          </form>';
    }
}

?>
