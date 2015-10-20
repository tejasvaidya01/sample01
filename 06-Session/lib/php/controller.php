<?php
// controller.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

session_start();

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
                ? htmlentities(trim($_REQUEST[$k]), ENT_QUOTES, 'UTF-8') : $v;

        foreach($g->ses as $k => $v)
            $_SESSION[$k] = $_SESSION[$k] ?? $v;

        $theme = $this->cache_theme();

        if (class_exists($theme)) {
            $t = $this->t = new $theme($g);
            $m = new Model($t, $g); // throwaway returned object
            foreach ($g->out as $k => $v)
                $g->out[$k] = method_exists($t, $k) ? $t->$k() : $v;
        }
    }

    public function __destruct()
    {
        $_SESSION['last'] = $this->g->in['p'];
    }

    public function __toString() : string
    {
        if (method_exists($this->t, 'html')) {
            if ($this->g->in['a'] === 'json') {
                header('Content-Type: application/json');
                return json_encode($this->g->out, JSON_PRETTY_PRINT);
            }
            return $this->t->html();
        }
    }

    public function cache_theme() : string
    {
        if (isset($_REQUEST['t'])) {
            if ($this->g->in['t'] !== $_SESSION['theme']) {
                $_SESSION['theme'] = $this->g->in['t'];
                // temporary msg demo
                util::msg('Changed theme to '.$_SESSION['theme'], 'success');
            }
        }
        return 'themes_'.$_SESSION['theme'];
    }
}
