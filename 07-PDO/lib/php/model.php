<?php
// model.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Model
{
    public function __construct(View $t, $g)
    {
        $c = new Pages;
        $p = INC.'pages/'.str_replace('_', DS, $g->in['p']).'.php';

        if (method_exists($c, $g->in['p'])) {
            $g->out['main'] = $c->{$g->in['p']}();
        } elseif (file_exists($p)) {
            $g->out['main'] = include $p;
        } elseif (class_exists($g->in['p'])) {
            db::$dbh = $g->dbh =  new db($g->db);
            $g->out['main'] = new $g->in['p']($t, $g);
        }
    }
}
