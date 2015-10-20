<?php
// index.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)
// https://github.com/markc/simple-php7-examples/tree/master/04-Autoload/README.md

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
        'm'     => '',                  // Message (type:message)
        'p'     => 'home',              // Page [home|about|contact]
    ],
    $out = [
        'doc'   => 'SPE::04',
        'css'   => '
    <link href="../lib/css/simple.css" media="all" rel="stylesheet">',
        'msg'   => '',
        'nav1'  => '',
        'head'  => 'Autoload',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015 Mark Constable (AGPL-3.0)',
    ],
    $nav1 = [
        ['Home', '?p=home'],
        ['About', '?p=about'],
        ['Contact', '?p=contact'],
    ];
});
