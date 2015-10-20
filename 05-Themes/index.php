<?php
// index.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)
// https://github.com/markc/simple-php7-examples/tree/master/05-Themes/README.md

declare(strict_types = 1);

const DS    = DIRECTORY_SEPARATOR;
const SYS   = __DIR__;
const INC   = SYS.DS.'lib'.DS.'php'.DS;

spl_autoload_register(function ($c) {
    $f = INC.str_replace(['\\', '_'], [DS, DS], strtolower($c)).'.php';
    if (file_exists($f)) include $f;
});

echo new Controller(new class
{
    public
    $cfg = [
        'file'  => '.htconf.php',       // override settings file
        'email' => 'markc@renta.net',   // site admin email
    ],
    $in = [
        'a'     => '',                  // Api [html(default)|json]
        'm'     => '',                  // Message area
        'p'     => 'home',              // Page [home|about|contact]
        't'     => 'none',              // current Theme
    ],
    $out = [
        'top'   => '',
        'meta'  => '',
        'doc'   => 'SPE::05',
        'css'   => '',
        'msg'   => '',
        'nav1'  => '',
        'nav2'  => '',
        'nav3'  => '',
        'head'  => 'Themes',
        'main'  => 'Missing home page',
        'foot'  => 'Copyright (C) 2015 Mark Constable (AGPL-3.0)',
        'end'   => '',
    ],
    $nav1 = [
        ['Home', '?p=home'],
        ['About', '?p=about'],
        ['Contact', '?p=contact'],
    ],
    $nav2 = [
        ['None', '?t=none'],
        ['Simple', '?t=simple'],
        ['Bootstrap', '?t=bootstrap'],
        ['Material', '?t=material'],
    ],
    $nav3 = [];
});

