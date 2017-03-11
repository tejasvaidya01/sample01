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
    
    protected function read_one() : array
    {
error_log(__METHOD__);

        $sql = "
 SELECT n.*, u.id as uid, u.login, u.fname, u.lname
   FROM news n
        JOIN users u
            ON n.author=u.id
  WHERE n.id=:nid";
    
        return db::qry($sql, ['nid' => $this->g->in['i']], 'one');
    }

    protected function read_all() : array
    {
error_log(__METHOD__);

        $sql = "
 SELECT n.*, u.id as uid, u.login, u.fname, u.lname
   FROM news n
        JOIN users u
            ON n.author=u.id
  ORDER BY n.updated DESC";

        return db::qry($sql, []);
    }
}

?>
