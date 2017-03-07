<?php
// lib/php/plugins/news.php 20150101 - 20170306
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugins_News extends Plugin
{
    protected
    $tbl = 'news',
    $in = [
        'title'     => '',
        'author'    => '',
        'content'   => '',
    ];
}

?>
