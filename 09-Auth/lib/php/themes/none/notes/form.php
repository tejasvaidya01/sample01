<?php
// notes/form.php 20151030 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

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
        <p style="text-align:right">' .
          $this->button($submit, 'submit', 'primary') . '
        </p>
        <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
        <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
        <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
      </form>';

