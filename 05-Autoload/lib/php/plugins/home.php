<?php
// lib/php/plugins/home.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugins_Home extends Plugin
{
    public function read() : string
    {
error_log(__METHOD__);

        $this->g->nav1 = array_merge($this->g->nav1, [
            ['Project Page', 'https://github.com/markc/spe/tree/master/05-Autoload'],
            ['Issue Tracker', 'https://github.com/markc/spe/issues'],
        ]);

        $buf = '
      <h2>Home</h2>
      <p>
This is an ultra simple single-file PHP7 framework and template system example.
Comments and pull requests are most welcome via the Issue Tracker link above.
      </p>';
        return $this->t->read(['buf' => $buf]);
    }
}
?>
