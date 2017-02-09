<?php
// view.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);
error_log(__FILE__);


class View extends Widgets
{
    protected $g = null;

    public function __construct($g)
    {
error_log(__METHOD__);

        $this->g = $g;
    }

    public function __call(string $name, array $args) : string
    {
error_log(__METHOD__."($name, args[])");


        if (method_exists($this, $name)) return $this->$name($args);

        $t1 = INC.'themes' . DS . $_SESSION['t'] . DS . str_replace('_', DS, $name).'.php';
        $t2 = INC.'themes' . DS . 'none' . DS . str_replace('_', DS, $name).'.php';
error_log("t1=".$t1);
error_log("t2=".$t2);

        if (isset($args[0]))
            extract($args[0]);
        else extract($args);

        if (file_exists($t1)) return include $t1;
        elseif (file_exists($t2)) return include $t2;
        else return 'Error: widget view does not exist: ' . $name;
    }

    public function log() : string
    {
error_log(__METHOD__);

        list($l, $m) = util::log();
        return $m ? '
      <p class="alert ' . $l . '">' . $m . '</p>' : '';
    }

    public function nav1() : string
    {
error_log(__METHOD__);

        $o = '?o='.$this->g->in['o'];
        return '
      <nav>' . join('', array_map(function ($n) use ($o) {
            $c = $o === $n[1] ? ' class="active"' : '';
            $i = isset($n[2]) ? '<i class="' . $n[2] . '"></i>' : '';
            return '
        <a' . $c . ' href="' . $n[1] . '">' . $i . $n[0] . '</a>';
        }, array_merge(util::which_usr($this->g->nav1), $this->g->nav2))) . '
      </nav>';
    }

    public function head() : string
    {
error_log(__METHOD__);

        return '
    <header>
      <h1>' . $this->g->out['head'] . '</h1>' . $this->g->out['nav1'] . '
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
    <footer>
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
  <body>' . $top . $head . $main . $foot . $end . '
  </body>
</html>
';
    }
}
