<?php
// lib/php/theme.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Theme
{
    private
    $buf = '',
    $in  = [];

    public function __construct($g)
    {
error_log(__METHOD__);

        $this->g = $g;
    }

    public function __toString() : string
    {
error_log(__METHOD__);

        return $this->buf;
    }

    public function log() : string
    {
error_log(__METHOD__);

        list($lvl, $msg) = util::log();
        return $msg ? '
      <p class="alert ' . $lvl . '">' . $msg . '</p>' : '';
    }

    public function nav1() : string
    {
error_log(__METHOD__);

        $o = '?o='.$this->g->in['o'];
        return '
      <nav>' . join('', array_map(function ($n) use ($o) {
            $c = $o === $n[1] ? ' class="active"' : '';
            return '
        <a' . $c . ' href="' . $n[1] . '">' . $n[0] . '</a>';
        }, $this->g->nav1)) . '
      </nav>';
    }

    public function head() : string
    {
error_log(__METHOD__);

        return '
    <header>
      <h1>
        <a href="' . $this->g->self . '">' . $this->g->out['head'] . '</a>
      </h1>' . $this->g->out['nav1'] . '
    </header>';
    }

    public function main() : string
    {
error_log(__METHOD__);

        return '
    <main>' . $this->g->out['log'] . $this->g->out['main'] . '
    </main>';
    }

    public function foot() : string
    {
error_log(__METHOD__);

        return '
    <footer class="text-center">
      <br>
      <p><em><small>' . $this->g->out['foot'] . '</small></em></p>
    </footer>';
    }

    public function html() : string
    {
error_log(__METHOD__);

        extract($this->g->out, EXTR_SKIP);
        return '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . $doc . '</title>' . $css . '
  </head>
  <body>' . $head . $main . $foot . '
  </body>
</html>
';
    }

    public function create(array $in) : string
    {
error_log(__METHOD__);

        return $in['buf'];
    }

    public function read(array $in) : string
    {
error_log(__METHOD__);

        return $in['buf'];
    }

    public function update(array $in) : string
    {
error_log(__METHOD__);

        return $in['buf'];
    }

    public function delete(array $in) : string
    {
error_log(__METHOD__);

        return $in['buf'];
    }
}

?>
