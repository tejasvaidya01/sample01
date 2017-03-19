<?php
// lib/php/themes/simple/news.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_Simple_News extends Themes_Simple_Theme {

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
          <h2><b><a href="?o=news&m=list">' . $title . '</a></b></h2>
          <table>
            <tbody>
              <tr>
                <td>' . nl2br($content) . '</td>
                <td class="text-center nowrap tblbg w200">
                  <small>
                    by <b>' . $author . '</b><br>
                    <i>' . util::now($updated) . '</i>
                  </small>
                </td>
              </tr>
            </tbody>
          </table>
          <br>
          <p class="text-right">
            <a class="btn" href="?o=news&m=list">&laquo; Back</a>
            <a class="btn btn-danger" href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
            <a class="btn btn-success" href="?o=news&m=update&i=' . $id . '">Update</a>
          </p>';
    }

    public function update(array $in) : string
    {
error_log(__METHOD__);

        return $this->editor($in);
    }

    private function editor(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);

        $header = $this->g->in['m'] === 'create' ? 'Add News' : 'Update News';
        $submit = $this->g->in['m'] === 'create' ? '
                <a class="btn btn-secondary" href="?o=news&m=list">&laquo; Back</a>
                <button type="submit" name="i" value="0" class="btn btn-success">Add This Item</button>' : '
                <a class="btn btn-secondary" href="?o=news&m=read&i=' . $id . '">&laquo; Back</a>
                <a class="btn btn-danger" href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
                <button type="submit" name="i" value="' . $id . '" class="btn btn-success">Update</button>';

        return '
          <h2><b><a href="?o=news&m=list">' . $header . '</a></b></h2>
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
            <br>
            <p class="text-right">' . $submit . '
            </p>
          </form>';
    }

    public function list(array $in) : string
    {
error_log(__METHOD__);

        $buf = $pgr_top = $pgr_end = '';
        $pgr = $in['pager']; unset($in['pager']);

        if ($pgr['last'] > 1)
            $pgr_top = $pgr_end = '
          <nav>' . $this->pager($pgr) . '
          </nav>';


        foreach ($in as $row) {
            extract($row);
            $buf .= '
              <tr>
                <td class="nowrap tblbg">
                  <a href="?o=news&m=read&i=' . $id . '" title="Show item">
                    <strong>' . $title . '</strong>
                  </a>
                </td>
                <td class="text-center nowrap tblbg w200" rowspan="2">
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
          <h2><b><a href="?o=news&m=create" title="Add news item">News (+)</a></b></h2>' . $pgr_top . '
          <table>
            <tbody>' . $buf . '
            </tbody>
          </table>' . $pgr_end;
    }

    private function pager(array $ary) : string
    {
error_log(__METHOD__);

        extract($ary);

        $b = '';
        $o = util::ses('o');

        for($i = 1; $i <= $last; $i++) {
            $c = $i === $curr ? ' class="active"' : '';
            $b .= '
            <a' . $c . ' href="?o=' . $o . '&m=list&p=' . $i . '">' . $i . '</a>';
        }

        return '
            <a href="?o=' . $o . '&m=list&p=' . $prev . '">&laquo;</a>' . $b . '
            <a href="?o=' . $o . '&m=list&p=' . $next . '">&raquo;</a>';
    }
}

?>
