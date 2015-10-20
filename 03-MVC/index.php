<?php
// index.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)
// https://github.com/markc/simple-php7-examples/tree/master/03-MVC/README.md

declare(strict_types = 1);

const DS    = DIRECTORY_SEPARATOR;
const SYS   = __DIR__;
const INC   = SYS.DS.'lib'.DS.'php'.DS;

echo new Controller(new class
{
    public
    $cfg = [
        'file'  => '.htconf.php',       // override settings file
        'email' => 'markc@renta.net',   // site admin email
    ],
    $in = [
        'a'     => '',                  // Api [html(default)|json]
        'm'     => '',                  // Message (type:message)
        'p'     => 'home',              // Page [home|about|contact]
    ],
    $out = [
        'doc'   => 'SPE::03',
        'css'   => '
    <link href="../lib/css/simple.css" media="all" rel="stylesheet">',
        'msg'   => '',
        'nav1'  => '',
        'head'  => 'MVC',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015 Mark Constable (AGPL-3.0)',
    ],
    $nav1 = [
        ['Home', '?p=home'],
        ['About', '?p=about'],
        ['Contact', '?p=contact'],
    ];
});

class Controller
{
    private $g = null;
    private $v = null;

    public function __construct($g)
    {
        $this->g = $g;

        if (file_exists($g->cfg['file']))
           foreach(include $g->cfg['file'] as $k => $v)
               $g->$k = array_merge($g->$k, $v);

        foreach ($g->in as $k => $v)
            $g->in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k])) : $v;

        $view = $this->v = new View(new Model($g));

        foreach ($g->out as $k => $v)
            $g->out[$k] = method_exists($view, $k) ? $view->$k() : $v;
    }

    public function __toString() : string
    {
        if ($this->g->in['a'] === 'json') {
            header('Content-Type: application/json');
            return json_encode($this->g->out, JSON_PRETTY_PRINT);
        }
        return $this->v->html();
    }
}

class Model
{
    public $g = null;

    public function __construct($g)
    {
        $this->g = $g;
        $c = new Pages;
        $p = INC.'pages/'.str_replace('_', DS, $g->in['p']).'.php';

        if (method_exists($c, $g->in['p']))
            $g->out['main'] = $c->{$g->in['p']}();
        elseif (file_exists($p))
            $g->out['main'] = include $p;
    }
}

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

class Pages
{
    function home() { return '<h2>Home Page</h2><p>Lorem ipsum home.</p>'; }
//    function about() { return '<h2>About Page</h2><p>Lorem ipsum about.</p>'; }
//    function contact() { return '<h2>Contact Page</h2><p>Lorem ipsum contact.</p>'; }
}
