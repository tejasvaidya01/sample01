<?php
// controller.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

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

        $theme = $this->cache_theme();

        if (class_exists($theme)) {
            $t = $this->t = new $theme($g);
            $m = new Model($t, $g); // throwaway returned object
            foreach ($g->out as $k => $v)
                $g->out[$k] = method_exists($t, $k) ? $t->$k() : $v;
        }
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
        $t = self::cookie_get('theme');

        if (isset($_REQUEST['t']) && $t !== $_REQUEST['t'])
            $this->g->in['t'] = self::cookie_put('theme', $this->g->in['t']);
        elseif ($t and $t !== $this->g->in['t']) $this->g->in['t'] = $t;
        else self::cookie_put('theme', $this->g->in['t']);

        return 'themes_'.$this->g->in['t'];
    }

    public static function cookie_get(string $name, string $default='') : string
    {
        return $_COOKIE[$name] ?? $default;
    }

    public static function cookie_put(string $name, string $value, int $expiry=604800) : string
    {
        return setcookie($name, $value, time() + $expiry, '/') ? $value : '';
    }

    public static function cookie_del(string $name) : string
    {
        return self::cookie_put($name, '', time() - 1);
    }
}
