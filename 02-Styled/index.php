<?php
// index.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)
// https://github.com/markc/simple-php7-examples/tree/master/02-Styled/README.md

declare(strict_types = 1);

echo new class extends View
{
    protected
    $in = [
        'a'     => '',      // Api [html(default)|json]
        'p'     => 'home',  // Page [home|about|contact]
    ],
    $out = [
        'doc'   => 'SPE::02',
        'css'   => '
    <link href="../lib/css/simple.css" media="all" rel="stylesheet">',
        'nav1'  => '',
        'head'  => '- S t y l e d -',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015 Mark Constable (AGPL-3.0)',
    ],
    $nav1 = [
        ['Home', '?p=home'],
        ['About', '?p=about'],
        ['Contact', '?p=contact'],
    ];

    public function __construct()
    {
        foreach ($this->in as $k => $v)
            $this->in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k])) : $v;

        foreach ($this->out as $k => $v)
            $this->out[$k] = method_exists($this, $k) ? $this->$k() : $v;
    }

    public function __toString() : string
    {
        if ($this->in['a'] === 'json') {
            header('Content-Type: application/json');
            return json_encode($this->out, JSON_PRETTY_PRINT);
        }
        return $this->html();
    }
};

class View
{
    protected function nav1() : string
    {
        $p = '?p='.$this->in['p'];
        return '
      <nav>' . join('', array_map(function ($n) use ($p) {
            $c = $p === $n[1] ? ' class="active"' : '';
            return '
        <a' . $c . ' href="' . $n[1] . '">' . $n[0] . '</a>';
        }, $this->nav1)) . '
      </nav>';
    }

    protected function head() : string
    {
        return '
    <header>
      <h1>' . $this->out['head'] . '</h1>' . $this->out['nav1'] . '
    </header>';
    }

    protected function main() : string
    {
        $content = new Pages;
        if (method_exists($content, $this->in['p']))
            $this->out['main'] = $content->{$this->in['p']}();
        return '
    <main>' . $this->out['main'] . '
    </main>';
    }

    protected function foot() : string
    {
        return '
    <footer>
      <p><em><small>' . $this->out['foot'] . '</small></em></p>
    </footer>';
    }

    protected function html() : string
    {
        extract($this->out, EXTR_SKIP);
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
    function about() { return '<h2>About Page</h2><p>Lorem ipsum about.</p>'; }
    function contact() { return '<h2>Contact Page</h2><p>Lorem ipsum contact.</p>'; }
}
