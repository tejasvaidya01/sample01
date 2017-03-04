<?php
// view.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class View extends Widgets
{
    protected $g = null;

    public function __construct($g)
    {
        $this->g = $g;
    }

    public function msg() : string
    {
        if ($this->g->in['m']) {
            list($c, $m) = explode(':', $this->g->in['m']);
            return '
      <p class="alert ' . $c . '">' . $m . '</p>';
        }
        return '';
    }

    public function nav1() : string
    {
        $p = '?p='.$this->g->in['p'];
        return '
      <nav>' . join('', array_map(function ($n) use ($p) {
            $c = $p === $n[1] ? ' class="active"' : '';
            return '
        <a' . $c . ' href="' . $n[1] . '">' . $n[0] . '</a>';
        }, array_merge($this->g->nav1, $this->g->nav2))) . '
      </nav>';
    }

    public function head() : string
    {
        return '
    <header>
      <h1>' . $this->g->out['head'] . '</h1>' . $this->g->out['nav1'] . '
    </header>';
    }

    public function main() : string
    {
        return '
    <main>' . $this->g->out['msg'] . $this->g->out['main'] . '
    </main>';
    }

    public function foot() : string
    {
        return '
    <footer>
      <p><em><small>' . $this->g->out['foot'] . '</small></em></p>
    </footer>';
    }

    public function html() : string
    {
        extract($this->g->out, EXTR_SKIP);
        return '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . $doc . '</title>' . $css . '
  </head>
  <body>' . $top . $head . $main . $foot . $end . '
  </body>
</html>
';
    }
}
