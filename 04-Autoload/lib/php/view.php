<?php
// 02-MVC 20150925 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class View
{
    private $g = null;

    public function __construct(Model $m)
    {
        $this->g = $m->g;
    }

    public function msg() : string
    {
        if ($this->g->in['m']) {
            list($c, $m) = explode(':', $this->g->in['m']);
            return '
      <p class="alert '.$c.'">'.$m.'</p>';
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
        }, $this->g->nav1)) . '
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
    <title>' . $doc . '</title>'.$css.'
  </head>
  <body>' . $head . $main . $foot . '
  </body>
</html>
';
    }
}
