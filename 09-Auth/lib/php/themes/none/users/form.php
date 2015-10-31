<?php
// users/form.php 20151030 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

return '
      <form method="post">
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
          <label for="altemail">Email</label>
          <input type="text" id="altemail" name="altemail" value="' . $altemail . '">
        </p>
        <p>
          <label for="anote">Note</label>
          <textarea rows="3" name="anote" id="anote">' . $anote . '</textarea>
        </p>
        <p style="text-align:right">' . $this->button($submit, 'submit', 'primary') . '</p>
        <input type="hidden" name="p" value="' . $this->g->in['p'] . '">
        <input type="hidden" name="a" value="' . $this->g->in['a'] . '">
        <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
      </form>';

