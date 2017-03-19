<?php
// lib/php/plugins/home.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugins_Home extends Plugin
{
    public function list() : string
    {
error_log(__METHOD__);

        if (!isset($_SESSION['ts']))
            $_SESSION['ts'] = (string) time();
        util::log("You first visited this page "  . util::now($_SESSION['ts']), 'success');

        $buf = '
      <h2>Home</h2>
      <p>
This is an ultra simple single-file PHP7 framework and template system example.
Comments and pull requests are most welcome via the Issue Tracker link above.
      </p>
      <p class="text-center">
        <a class="btn btn-primary" href="https://github.com/markc/spe">Project Page</a>
        <a class="btn btn-primary" href="https://github.com/markc/spe/issues">Issue Tracker</a>
        <a class="btn btn-success" href="?t=none">No Theme</a>
        <a class="btn btn-success" href="?t=simple">Simple Theme</a>
        <a class="btn btn-success" href="?t=bootstrap">Bootstrap 4</a>
      </p>';
        return $this->t->list(['buf' => $buf]);
    }
}

?>
