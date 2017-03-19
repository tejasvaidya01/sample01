<?php
// index.php 20150101 - 20170317
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

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
    $email      = 'markc@renta.net',
    $file       = 'lib' . DS . '.ht_conf.php', // settings override
    $perp       = 5, // items Per Page
    $self       = '',
    $in = [
        'i'     => null,        // Item/ID
        'l'     => '',          // Log (message)
        'm'     => 'list',      // Method (action)
        'o'     => 'home',      // Object (content)
        'p'     => 1,           // Page (current)
        't'     => 'bootstrap', // Theme (current)
        'x'     => '',          // XHR (request)
    ],
    $out = [
        'doc'   => 'SPE::07',
        'css'   => '',
        'log'   => '',
        'nav1'  => '',
        'nav2'  => '',
        'head'  => 'PDO',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015-2017 Mark Constable (AGPL-3.0)',
    ],
    $db = [
        'host'  => '127.0.0.1', // DB site
        'name'  => 'spe_07',    // DB name
        'pass'  => 'lib' . DS . '.ht_pw', // MySQL password override
        'path'  => 'lib' . DS . '.ht_news.sqlite', // SQLite DB
        'port'  => '3306',      // DB port
        'sock'  => '',          // '/run/mysqld/mysqld.sock',
        'type'  => 'mysql',    // mysql | sqlite
        'user'  => 'sysadm',    // DB user
    ],
    $nav1 = [
        ['About',       '?o=about', 'fa fa-info-circle fa-fw'],
        ['Contact',     '?o=contact', 'fa fa-envelope fa-fw'],
        ['News',        '?o=news', 'fa fa-envelope fa-fw'],
    ],
    $nav2 = [
        ['None',        '?t=none'],
        ['Simple',      '?t=simple'],
        ['Bootstrap',   '?t=bootstrap'],
    ];
});

?>
