<?php
// index.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

error_log('GET=' . var_export($_GET, true));
error_log('POST=' . var_export($_POST, true));

const DS  = DIRECTORY_SEPARATOR;
const INC = __DIR__ . DS . 'lib' . DS . 'php' . DS;

spl_autoload_register(function ($c) {
    $f = INC . str_replace(['\\', '_'], [DS, DS], strtolower($c)) . '.php';
    if (file_exists($f)) include $f;
    else error_log("!!! $f does not exist");
});

echo new Init(new class
{
    public
    $self       = '',
    $email      = 'markc@renta.net',
    $in = [
        'l'     => '',          // Log (message)
        'm'     => 'read',      // Method (action)
        'o'     => 'home',      // Object (content)
        't'     => 'simple', // Theme
        'x'     => '',          // XHR (request)
    ],
    $out = [
        'doc'   => 'SPE::05',
        'css'   => '',
        'log'   => '',
        'nav1'  => '',
        'nav2'  => '',
        'head'  => 'Autoload',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015-2017 Mark Constable (AGPL-3.0)',
    ],
    $nav1 = [
        ['About',       '?o=about', 'fa fa-info-circle fa-fw'],
        ['Contact',     '?o=contact', 'fa fa-envelope fa-fw'],
    ],
    $nav2 = [
        ['None',        '?t=none'],
        ['Simple',      '?t=simple'],
        ['Bootstrap',   '?t=bootstrap'],
    ];
});
?>
