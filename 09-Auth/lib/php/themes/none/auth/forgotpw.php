<?php
// auth/forgotpw.php 20151030 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

return '
      <h2>Reset password</h2>
      <form method="post">
        <input type="hidden" name="p" value="auth">
        <input type="hidden" name="a" value="forgotpw">
        <p>
          <label for="uid">Email Address</label>
          <input type="email" name="uid" id="uid" placeholder="Your Email Address" value="' . $uid . '" required autofocus>
        </p>
        <p>
You will receive an email with further instructions and please
note that this only resets the password for this website interface.
        </p>
        <p style="text-align:right">'
           . $this->a('?p=auth&amp;a=signin', '&laquo; Back')
           . $this->button('Send', 'submit', 'primary') . '
        </p>
      </form>';
