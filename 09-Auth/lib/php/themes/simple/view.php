<?php
// simple.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Themes_Simple_View extends View
{
    function css()
    {
        return '
    <link href="//fonts.googleapis.com/css?family=Roboto:500,400,300,300italic,100,100italic" rel="stylesheet" type="text/css">
    <link href="../lib/css/simple.css" media="all" rel="stylesheet">';
    }

    public function nav1(array $a = []) : string
    {
        $a = isset($a[0]) ? $a : util::which_usr($this->g->nav1);
        $p = '?p='.$_SESSION['p'];
        $t = '?t='.$_SESSION['t'];
        return '
      <nav>'.join('', array_map(function ($n) use ($p, $t) {
            $c = $p === $n[1] ? ' class="active"' : '';
            return '
        <a'.$c.' href="'.$n[1].'">'.$n[0].'</a>';
        }, $a)).'
        <ul>
          <li>
            <a href="#">Themes</a>
            <ul>'.join('', array_map(function ($n) use ($p, $t) {
            $c = $t === $n[1] ? ' class="active"' : '';
            return '
              <li><a'.$c.' href="'.$n[1].'">'.$n[0].'</a></li>';
        }, $this->g->nav2)).'
            </ul>
          </li>
        </ul>
      </nav>';
    }

    public function veto_a(string $href, string $label, string $class, string $extra) : array
    {
        return ['class' => 'btn '.$class];
    }
}
