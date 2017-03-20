<?php
// lib/php/plugins/news.php 20150101 - 20170317
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugins_News extends Plugin
{
    protected
    $tbl = 'news',
    $in = [
        'title'     => '',
        'author'    => 1,
        'content'   => '',
    ];

    protected function read() : string
    {
error_log(__METHOD__);

        $sql = "
 SELECT n.*, u.id as uid, u.login, u.fname, u.lname
   FROM news n
        JOIN users u
            ON n.author=u.id
  WHERE n.id=:nid";

        return $this->t->read(db::qry($sql, ['nid' => $this->g->in['i']], 'one'));
    }

    protected function list() : string
    {
error_log(__METHOD__);

        $pager = util::pager(
            (int) util::ses('p'),
            (int) $this->g->perp,
            (int) db::qry("SELECT count(*) FROM news n JOIN users u ON n.author=u.id", [], 'col')
        );

        $sql = "
 SELECT n.*, u.id as uid, u.login, u.fname, u.lname
   FROM news n
        JOIN users u
            ON n.author=u.id
  ORDER BY n.updated DESC LIMIT " . $pager['start'] . "," . $pager['perp'];

        return $this->t->list(array_merge(db::qry($sql), ['pager' => $pager]));
    }
}

?>
