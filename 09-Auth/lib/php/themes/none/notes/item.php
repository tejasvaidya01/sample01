<?php
// notes/item.php 20151030 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

return '
      <hr>
      <table>
        <tr>
          <td><h3><a href="?o=notes&m=read&i=' . $id . '">' . $title . '</a></h3></td>
          <td style="text-align:right"><em><i>' . util::now($updated) . '</em></i></td>
        </tr>
        <tr>
          <td>by <b>' . $author . '</b></td>
          <td style="text-align:right">
            <small>
              <a href="?o=notes&m=update&i=' . $id . '" title="Update">E</a>
              <a href="?o=notes&m=delete&i=' . $id . '" title="Delete" onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')">X</a>
            </small>
          </td>
        </tr>
        <tr>
          <td colspan="2"><p>' . nl2br($content) . '</p></td>
        </tr>
      </table>';
