<?php
// notes/item.php 20151030 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

return '
      <hr>
      <table>
        <tr>
          <td><h3><a href="?p=notes&a=read&i=' . $id . '">' . $title . '</a></h3></td>
          <td style="text-align:right">by <b>' . $author . '</b>
          </td>
        </tr>
        <tr>
          <td><em><i>' . util::now($updated) . '</em></i></td>
          <td style="text-align:right">
            <small>
              <a href="?p=notes&a=update&i=' . $id . '" title="Update">E</a>
              <a href="?p=notes&a=delete&i=' . $id . '" title="Delete" onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')">X</a>
            </small>
          </td>
        </tr>
        <tr>
          <td colspan="2"><p>' . nl2br($content) . '</p></td>
        </tr>
      </table>';
