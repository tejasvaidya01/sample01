<?php
// index.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);
error_log(__FILE__);


const DS    = DIRECTORY_SEPARATOR;
const INC   = __DIR__ . DS . 'lib' . DS . 'php' . DS;
const SYS   = __DIR__ . DS . 'lib' . DS . 'sys' . DS; // system file management path

spl_autoload_register(function ($c) {
    $f = INC.str_replace(['\\', '_'], [DS, DS], strtolower($c)).'.php';
    if (file_exists($f)) include $f;
});

echo new Controller(new class
{
    public
    $lock = true,
    $self = '',
    $cfg = [
        'file'      => 'lib'.DS.'.ht_conf.php', // override settings file
        'email'     => 'markc@renta.net',       // site admin email
    ],
    $in = [
        'g'         => 0,                       // Group (category)
        'i'         => 0,                       // Item or ID
        'l'         => '',                      // Logging [lvl:msg]
        'm'         => 'read',                  // Method action
        'n'         => 1,                       // Navigation
        'o'         => 'home',                  // Object module
        't'         => 'bootstrap',             // current Theme
        'x'         => '',                      // XHR requests
    ],
    $out = [
        'top'       => '',
        'meta'      => '',
        'doc'       => 'SPE::10',
        'css'       => '',
        'log'       => '',
        'nav1'      => '',
        'nav2'      => '',
        'nav3'      => '',
        'head'      => 'Fileman',
        'main'      => 'Missing home page',
        'foot'      => 'Copyright (C) 2015-2016 Mark Constable (AGPL-3.0)',
        'end'       => '',
    ],
    $db = [
        'host'      => '127.0.0.1',
        'name'      => 'spe',
        'pass'      => 'lib' . DS . '.ht_pw.php',
        'path'      => 'lib' . DS . '.ht_spe.sqlite',
        'port'      => '3306',
        'sock'      => '', // '/run/mysqld/mysqld.sock',
        'type'      => 'sqlite', // mysql|sqlite
        'user'      => 'root',
    ],
    $nav1 = [
        'non' => [
            ['About',       '?o=about', 'fa fa-info fa-fw'],
            ['Contact',     '?o=contact', 'fa fa-envelope fa-fw'],
            ['Notes',       '?o=notes', 'fa fa-file-text fa-fw'],
            ['Sign in',     '?o=auth&m=signin', 'fa fa-sign-in fa-fw'],
        ],
        'usr' => [
            ['Files',       '?o=files', 'fa fa-folder fa-fw'],
            ['Notes',       '?o=notes', 'fa fa-file-text fa-fw'],
            ['Sign out',    '?o=auth&m=signout', 'fa fa-sign-out fa-fw'],
        ],
        'adm' => [
            ['Files',       '?o=files', 'fa fa-folder fa-fw'],
            ['Notes',       '?o=notes', 'fa fa-file-text fa-fw'],
            ['Users',       '?o=users', 'fa fa-users fa-fw'],
            ['Sign out',    '?o=auth&m=signout', 'fa fa-sign-out fa-fw'],
        ],
    ],
    $nav2 = [
        ['None',        '?t=none'],
        ['Simple',      '?t=simple'],
        ['Bootstrap',   '?t=bootstrap'],
        ['Material',    '?t=material'],
    ],
    $acl = [
        0 => 'Anonymous',
        1 => 'Administrator',
        2 => 'User',
        3 => 'Suspended',
    ];
});

function dbg($var = null)
{
    if (is_object($var))
        error_log(ReflectionObject::export($var, true));
    ob_start();
    print_r($var);
    $ob = ob_get_contents();
    ob_end_clean();
    error_log($ob);
}
