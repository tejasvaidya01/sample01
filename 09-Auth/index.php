<?php
// index.php 20150101 - 20170305
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
    $email      = 'admin@goldcoast.org',
    $file       = 'lib' . DS . '.ht_conf.php', // settings override
    $self       = '',
    $in = [
        'i'     => 0,           // Item or ID
        'l'     => '',          // Log (message)
        'm'     => 'read',      // Method (action)
        'o'     => 'home',      // Object (content)
        't'     => 'bootstrap', // Theme
        'x'     => '',          // XHR (request)
    ],
    $out = [
        'doc'   => 'SPE::09',
        'css'   => '',
        'log'   => '',
        'nav1'  => '',
        'nav2'  => '',
        'head'  => 'Auth',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015-2017 Mark Constable (AGPL-3.0)',
    ],
    $db = [
        'host'  => '127.0.0.1', // DB site
        'name'  => 'sysadm',    // DB name
        'pass'  => 'lib' . DS . '.ht_pw.php', // MySQL password override
        'path'  => 'lib' . DS . '.ht_spe.sqlite', // SQLite DB
        'port'  => '3306',      // DB port
        'sock'  => '',          // '/run/mysqld/mysqld.sock',
        'type'  => 'sqlite',    // mysql | sqlite
        'user'  => 'sysadm',    // DB user
    ],
    $nav1 = [
        'non' => [
            ['About',       '?o=about', 'fa fa-info-circle fa-fw'],
            ['Contact',     '?o=contact', 'fa fa-envelope fa-fw'],
            ['News',        '?o=news', 'fa fa-file-text fa-fw'],
            ['Sign in',     '?o=auth', 'fa fa-sign-in fa-fw'],
        ],
        'usr' => [
            ['News',        '?o=news', 'fa fa-file-text fa-fw'],
            ['Sign out',    '?o=auth&m=delete', 'fa fa-sign-out fa-fw'],
        ],
        'adm' => [
            ['News',        '?o=news', 'fa fa-file-text fa-fw'],
            ['Users',       '?o=users', 'fa fa-users fa-fw'],
            ['Sign out',    '?o=auth&m=delete', 'fa fa-sign-out fa-fw'],
        ],
    ],
    $nav2 = [
        ['None',        '?t=none'],
        ['Simple',      '?t=simple'],
        ['Bootstrap',   '?t=bootstrap'],
    ],
    $acl = [
        0 => 'Anonymous',
        1 => 'SuperAdmin',
        2 => 'Administrator',
        3 => 'User',
        4 => 'Suspended',
    ];
});

?>
