<?php
// lib/php/themes/none/news.php 20150101 - 20170317
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_None_News extends Themes_None_Theme
{
    public function create(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    public function read(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);

        return '
          <h3><a href="?o=news&m=read&i=0">&laquo; ' . $title . '</a></h3>
          <table>
            <tbody>
              <tr><td>' . nl2br($content) . '<br></td><tr>
              </tr><td><small><i>by <b>' . $author . '</b> ' . util::now($updated) . '</i></small></td></tr>
            </tbody>
          </table>
          <p>
            <a href="?o=news&m=read&i=0">&laquo; Back</a>
            | <a href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
            | <a href="?o=news&m=update&i=' . $id . '">Update</a>
          </p>';
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
        foreach ($in as $row) {
            extract($row);
            $buf .= '
                <tr>
                  <td>
                    <a href="?o=news&m=read&i=' . $id . '" title="Show item">
                      <strong>' . $title . '</strong>
                    </a>
                  </td>
                  <td rowspan="2">
                    <small>
                      by <b>' . $author . '</b><br>
                      <i>' . util::now($updated) . '</i>
                    </small>
                  </td>
                </tr>
                <tr>
                  <td><p>' . nl2br($content) . '</p></td>
                </tr>';
        }

        return '
          <h3><a href="?o=news&m=create" title="Add news item">News (+)</a></h3>
          <table>
            <tbody>' . $buf . '
            </tbody>
          </table>';
    }

    private function editor(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);
        $header = $this->g->in['m'] === 'create' ? 'Add News' : 'Update News';
        $submit = $this->g->in['m'] === 'create' ? '
              <a href="?o=news&m=list">&laquo; Back</a>
              <button type="submit" name="i" value="0">Add This Item</button>' : '
              <a href="?o=news&m=list">&laquo; Back</a>
              <a href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
              <button type="submit" name="i" value="' . $id . '">Update</button>';

        return '
          <h3><a href="?o=news&m=list">&laquo; ' . $header . '</a></h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <p>
              <label for="title">Title</label><br>
              <input type="text" id="title" name="title" value="' . $title . '" required>
            </p>
            <p>
              <label for="author">Author</label><br>
              <input type="text" id="author" name="author" value="' . $author . '" required>
            </p>
            <p>
              <label for="content">Content</label><br>
              <textarea id="content" name="content" rows="9" required>' . $content . '</textarea>
            </p>
            <p>' . $submit . '
            </p>
          </form>';
    }

}

?>
