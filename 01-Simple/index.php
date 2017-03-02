<?php
// index.php 20150101 - 20170302
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

echo new class
{
    private
    $in = [
        'g'     => 0,           // Group (category)
        'i'     => 0,           // Item or ID
        'l'     => '',          // Logging [lvl:msg]
        'm'     => 'home',      // Method action
        'n'     => 1,           // Navigation
        'o'     => 'home',      // Object module
        't'     => '',          // current Theme
        'x'     => '',          // XHR request
    ],
    $out = [
        'doct'  => 'SPE::01',
        'nav1'  => '',
        'head'  => 'Simple',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015-2017 Mark Constable (AGPL-3.0)',
    ],
    $nav1 = [
        ['Home', '?m=home'],
        ['About', '?m=about'],
        ['Contact', '?m=contact'],
    ];

    public function __construct()
    {
        foreach ($this->in as $k => $v)
            $this->in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k])) : $v;

        if (method_exists($this, $this->in['m']))
            $this->out['main'] = $this->{$this->in['m']}();

        foreach ($this->out as $k => $v)
            $this->out[$k] = method_exists($this, $k) ? $this->$k() : $v;
    }

    public function __toString() : string
    {
        if ($this->in['x']) {
            $xhr = $this->out[$this->in['x']] ?? '';
            if ($xhr) return $xhr;
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

    private function home() { return '<h2>Home Page</h2><p>Lorem ipsum home.</p>'; }
    private function about() { return '<h2>About Page</h2><p>Lorem ipsum about.</p>'; }
    private function contact() { return '<h2>Contact Page</h2><p>Lorem ipsum contact.</p>'; }
};

