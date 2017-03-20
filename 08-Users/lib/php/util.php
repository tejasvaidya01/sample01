<?php
// lib/php/util.php 20150225 - 20170306
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Util
{
    public static function log(string $msg = '', string $lvl = 'danger') : array
    {
error_log(__METHOD__);

        if ($msg) {
            $_SESSION['l'] = $lvl . ':' . $msg;
        } elseif (isset($_SESSION['l']) and $_SESSION['l']) {
            $l = $_SESSION['l']; $_SESSION['l'] = '';
            return explode(':', $l, 2);
        }
        return ['', ''];
    }

    public static function esc(array $in) : array
    {
error_log(__METHOD__);

        foreach ($in as $k => $v)
            $in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k]), ENT_QUOTES, 'UTF-8') : $v;
        return $in;
    }

    public static function ses(string $k, string $v = '', string $x = null) : string
    {
error_log(__METHOD__."($k, $v, $x)");

        return $_SESSION[$k] =
            (!is_null($x) && (!isset($_SESSION[$k]) || ($_SESSION[$k] != $x))) ? $x :
                (((isset($_REQUEST[$k]) && !isset($_SESSION[$k]))
                    || (isset($_REQUEST[$k]) && isset($_SESSION[$k])
                    && ($_REQUEST[$k] != $_SESSION[$k])))
                ? htmlentities(trim($_REQUEST[$k]), ENT_QUOTES, 'UTF-8')
                : ($_SESSION[$k] ?? $v));
    }

    public static function cfg($g) : void
    {
error_log(__METHOD__);

        if (file_exists($g->file))
           foreach(include $g->file as $k => $v)
               $g->$k = array_merge($g->$k, $v);
    }

    public static function now($date1, $date2 = null)
    {
error_log(__METHOD__);

        if (!is_numeric($date1)) $date1 = strtotime($date1);
        if ($date2 and !is_numeric($date2)) $date2 = strtotime($date2);
        $date2 = $date2 ?? time();
        $diff = abs($date1 - $date2);
        if ($diff < 10) return ' just now';

        $blocks = [
            ['k' => 'year', 'v' => 31536000],
            ['k' => 'month','v' => 2678400],
            ['k' => 'week', 'v' => 604800],
            ['k' => 'day',  'v' => 86400],
            ['k' => 'hour', 'v' => 3600],
            ['k' => 'min',  'v' => 60],
            ['k' => 'sec',  'v' => 1],
        ];
        $levels = 2;
        $current_level = 1;
        $result = [];

        foreach ($blocks as $block) {
            if ($current_level > $levels) {
                break;
            }
            if ($diff / $block['v'] >= 1) {
                $amount = floor($diff / $block['v']);
                $plural = ($amount > 1) ? 's' : '';
                $result[] = $amount . ' ' . $block['k'] . $plural;
                $diff -= $amount * $block['v'];
                ++$current_level;
            }
        }
        return implode(' ', $result) . ' ago';
    }

    public static function pager(int $curr, int $perp, int $total) : array
    {
error_log(__METHOD__);

        $start = ($curr - 1) * $perp;
        $last  = intval(ceil($total / $perp));
        $curr  = $curr < 1 ? 1 : ($curr > $last ? $last : $curr);
        $prev  = $curr < 2 ? 1 : $curr - 1;
        $next  = $curr > ($last - 1) ? $last : $curr + 1;

        return [
            'start' => $start,
            'prev'  => $prev,
            'curr'  => $curr,
            'next'  => $next,
            'last'  => $last,
            'perp'  => $perp,
            'total' => $total
        ];
    }

    public static function is_adm() : bool
    {
error_log(__METHOD__);

        return isset($_SESSION['adm']);
    }

    public static function is_usr(int $id = null) : bool
    {
error_log(__METHOD__);

        return (is_null($id))
            ? isset($_SESSION['usr'])
            : isset($_SESSION['usr']['id']) && $_SESSION['usr']['id'] == $id;
    }

    public static function is_acl(int $acl) : bool
    {
error_log(__METHOD__);

        return isset($_SESSION['usr']['acl']) && $_SESSION['usr']['acl'] == $acl;
    }
}

?>
