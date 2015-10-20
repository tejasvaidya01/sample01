<?php
// model.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Model
{
    public function __construct(View $t, $g)
    {
        $p = INC.'pages/'.str_replace('_', DS, $g->in['p']).'.php';

        if (method_exists($this, $g->in['p'])) {
            $g->out['main'] = $this->{$g->in['p']}();
        } elseif (file_exists($p)) {
            $g->out['main'] = include $p;
        } elseif (class_exists($g->in['p'])) {
            db::$dbh = $g->dbh =  new db($g->db);
            $g->out['main'] = new $g->in['p']($t, $g);
        }
    }

//    function home() { return '<h2>Home Page</h2><p>Lorem ipsum home.</p>'; }
//    function about() { return '<h2>About Page</h2><p>Lorem ipsum about.</p>'; }
//    function contact() { return '<h2>Contact Page</h2><p>Lorem ipsum contact.</p>'; }
}
