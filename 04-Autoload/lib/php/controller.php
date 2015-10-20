<?php
// controller.php 20150925 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Controller
{
    private $g = null;
    private $v = null;

    public function __construct($g)
    {
        $this->g = $g;

        if (file_exists($g->cfg['file']))
           foreach(include $g->cfg['file'] as $k => $v)
               $g->$k = array_merge($g->$k, $v);

        foreach ($g->in as $k => $v)
            $g->in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k])) : $v;

        $view = $this->v = new View(new Model($g));

        foreach ($g->out as $k => $v)
            $g->out[$k] = method_exists($view, $k) ? $view->$k() : $v;
    }

    public function __toString() : string
    {
        if ($this->g->in['a'] === 'json') {
            header('Content-Type: application/json');
            return json_encode($this->g->out, JSON_PRETTY_PRINT);
        }
        return $this->v->html();
    }
}
