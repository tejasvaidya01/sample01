<?php
// simple.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Themes_Simple extends View
{
    function css()
    {
        return '
    <link href="//fonts.googleapis.com/css?family=Roboto:400,100,300,100italic" rel="stylesheet" type="text/css">
    <link href="../lib/css/simple.css" media="all" rel="stylesheet">
<style>
    ul { list-style: none; padding: 0px; margin: 0px; }
    ul li { display: block;position: relative; float: left; border:1px solid #000}
    li ul { display: none;}
    ul li a { display: block; background: #000; padding: 5px 10px 5px 10px; text-decoration: none; white-space: nowrap; color: #fff; }
    ul li a:hover { background: #f00; }
    li:hover ul { display: block; position: absolute; }
    li:hover li { float: none; }
    li:hover a { background: #f00; }
    li:hover li a:hover { background: #000; }
    #drop-nav li ul li { border-top: 0px; }
</style>';
    }

    public function nav1() : string
    {
        $p = '?p='.$this->g->in['p'];
        $t = '?t='.$this->g->in['t'];
        return '
      <nav>'.join('', array_map(function ($n) use ($p, $t) {
            $c = $p === $n[1] || $t === $n[1] ? ' class="active"' : '';
            return '
        <a'.$c.' href="'.$n[1].'">'.$n[0].'</a>';
        }, array_merge($this->g->nav1, $this->g->nav2))).'
      </nav>';
    }

    public function veto_a($href, $label, $class, $extra)
    {
        return ['class' => 'btn '.$class];
    }
}
