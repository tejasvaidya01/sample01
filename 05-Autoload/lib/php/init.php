<?php
// lib/php/init.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Init
{
    private $t = null;

    public function __construct($g)
    {
error_log(__METHOD__);

        $g->self = str_replace('index.php', '', $_SERVER['PHP_SELF']);

        foreach ($g->in as $k => $v)
            $g->in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k])) : $v;

        $p  = 'plugins_' . $g->in['o'];
        $t  = 'themes_' . $g->in['t'] . '_' . $g->in['o'];
        $tt = 'themes_' . $g->in['t'] . '_theme';

        $this->t = $thm = class_exists($t) ? new $t($g)
            : (class_exists($tt) ? new $tt($g) : new Theme($g));

        if (class_exists($p)) $g->out['main'] = (string) new $p($thm);
        else $g->out['main'] = "Error: no plugin object!";

        foreach ($g->out as $k => $v)
            $g->out[$k] = method_exists($thm, $k) ? $thm->$k() : $v;

    }

    public function __toString() : string
    {
error_log(__METHOD__);

        $g = $this->t->g;

        if ($g->in['x']) {
            $xhr = $g->out[$g->in['x']] ?? '';
            if ($xhr) return $xhr;
            header('Content-Type: application/json');
            return json_encode($g->out, JSON_PRETTY_PRINT);
        }
        return $this->t->html();
    }
}
?>
