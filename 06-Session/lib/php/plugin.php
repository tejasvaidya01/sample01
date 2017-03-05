<?php
// lib/php/plugin.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugin
{
    protected
    $buf = '',
    $in  = [];

    public function __construct(Theme $t)
    {
error_log(__METHOD__);

        $this->t    = $t;
        $this->g    = $t->g;
        $this->buf .= $this->{$t->g->in['m']}();
    }

    public function __toString() : string
    {
error_log(__METHOD__);

        return $this->buf;
    }

    public function create() : string
    {
error_log(__METHOD__);

        return "<p>Plugin::create() not implemented yet!</p>";
    }

    public function read() : string
    {
error_log(__METHOD__);

        return "<p>Plugin::read() not implemented yet!</p>";
    }

    public function update() : string
    {
error_log(__METHOD__);

        return "<p>Plugin::update() not implemented yet!</p>";
    }

    public function delete() : string
    {
error_log(__METHOD__);

        return "<p>Plugin::delete() not implemented yet!</p>";
    }
}

?>
