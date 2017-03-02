<?php
// index.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)
// https://github.com/markc/simple-php7-examples/tree/master/01-Simplest/README.md

declare(strict_types = 1);

echo new class
{
    private
    $in = [
        'a'     => '',      // Api [html(default)|json]
        'p'     => 'home',  // Page [home|about|contact]
    ],
    $out = [
        'doct'  => 'SPE::01',
        'nav1'  => '',
        'head'  => 'Simplest',
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

    private function nav1() : string
    {
        return '
      <nav>' . join('', array_map(function ($n) {
            return '
        <a href="' . $n[1] . '">' . $n[0] . '</a>';
        }, $this->nav1)) . '
      </nav>';
    }

    private function head() : string
    {
        return '
    <header>
      <h1>' . $this->out['head'] . '</h1>' . $this->out['nav1'] . '
    </header>';
    }

    private function main() : string
    {
        $content = new Pages;
        if (method_exists($content, $this->in['p']))
            $this->out['main'] = $content->{$this->in['p']}();
        return '
    <main>' . $this->out['main'] . '
    </main>';
    }

    private function foot() : string
    {
        return '
    <footer>
      <p><em><small>' . $this->out['foot'] . '</small></em></p>
    </footer>';
    }

    private function html() : string
    {
        extract($this->out, EXTR_SKIP);
        return '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . $doct . '</title>
  </head>
  <body>' . $head . $main . $foot . '
  </body>
</html>
';
    }
};

class Pages
{
    function home() { return '<h2>Home Page</h2><p>Lorem ipsum home.</p>'; }
    function about() { return '<h2>About Page</h2><p>Lorem ipsum about.</p>'; }
    function contact() { return '<h2>Contact Page</h2><p>Lorem ipsum contact.</p>'; }
}

