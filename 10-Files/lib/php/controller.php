<?php
// controller.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);
error_log(__FILE__);

session_start();
//$_SESSION = [];
error_log('GET='.var_export($_GET, true));
error_log('POST='.var_export($_POST, true));
error_log('SESSION='.var_export($_SESSION, true));

class Controller
{
    private $g = null;
    private $t = null;

    public function __construct($g)
    {
error_log(__METHOD__);

        $g->self = str_replace('index.php', '', $_SERVER['PHP_SELF']);

        $this->g = &$g;
        util::cfg($g);
        $g->in = util::esc($g->in);
        $theme = 'themes_' . (util::ses('t', $g->in['t'])) . '_view';
        $t = $this->t = class_exists($theme) ? new $theme($g) : new View($g);

        if ($this->g->in['x']) {
            $this->g->out[$g->in['x']] = (string) new $g->in['o']($t, $g);
        } else {
            $m = new Model($t, $g); // throwaway returned object
            foreach ($g->out as $k => $v)
                $g->out[$k] = method_exists($t, $k) ? $t->$k() : $v;
        }
    }

    public function __destruct()
    {
error_log(__METHOD__);

//error_log('SESSION='.var_export($_SESSION, true));
        error_log($_SERVER['REMOTE_ADDR'].' '.round((microtime(true)-$_SERVER['REQUEST_TIME_FLOAT']), 4)."\n");
    }

    public function __toString() : string
    {
        if (isset($this->t)) {
            if ($this->g->in['x']) {
                header('Content-Type: application/json');
                if ($this->g->out[$this->g->in['x']]) {
                    return $this->g->out[$this->g->in['x']];
                } else {
                    return json_encode($this->g->out, JSON_PRETTY_PRINT);
                }
            } else if (method_exists($this->t, 'html')) {
                return $this->t->html();
            } else return "Error: no html() method!";
        } else return "Error: no theme!";
    }
}
