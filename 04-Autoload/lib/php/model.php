<?php
// model.php 20150925 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Model
{
    public $g = null;

    public function __construct($g)
    {
        $this->g = $g;
        $c = new Pages;
        $p = INC.'pages/'.str_replace('_', DS, $g->in['p']).'.php';

        if (method_exists($c, $g->in['p']))
            $g->out['main'] = $c->{$g->in['p']}();
        elseif (file_exists($p))
            $g->out['main'] = include $p;
    }
}
