<?php
// util.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Util
{
    public static function msg(string $msg = '', string $lvl = 'danger') : array
    {
        if ($msg) {
            if (strpos($msg, ':')) list($lvl, $msg) = explode(':', $msg);
            $_SESSION['m'] = $msg;
            $_SESSION['l'] = $lvl;
        } elseif ($_SESSION['m']) {
            if (strpos($_SESSION['m'], ':')) {
                list($l, $m) = explode(':', $_SESSION['m']);
                $_SESSION['l'] = $l;
                $_SESSION['m'] = $m;
            }
            $l = $_SESSION['l']; $_SESSION['l'] = '';
            $m = $_SESSION['m']; $_SESSION['m'] = '';
            return [$l, $m];
        }
        return ['', ''];
    }

    public static function esc(array $in)
    {
        foreach ($in as $k => $v)
            $in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k]), ENT_QUOTES, 'UTF-8') : $v;
        return $in;
    }

    public static function which_nav(array $nav = []) : array
    {
        return isset($_SESSION['usr'])
            ? (isset($_SESSION['adm']) ? $nav['adm'] : $nav['usr'])
            : $nav['non'];
    }

    public static function sef($url, $sef = false)
    {
      return $sef
      ? preg_replace('/[\&].=/', '/', preg_replace('/[\?].=/', '', $url))
      : $url;
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

    public static function chkpw($pw, $pw2)
    {
        if (strlen($pw) > 9) {
            if (preg_match('/[0-9]+/', $pw)) {
                if (preg_match('/[A-Z]+/', $pw)) {
                    if (preg_match('/[a-z]+/', $pw)) {
                        if ($pw === $pw2) {
                            return true;
                        } else self::msg('Passwords do not match, please try again');
                    } else self::msg('Password must contains at least one lower case letter');
                } else self::msg('Password must contains at least one captital letter');
            } else self::msg('Password must contains at least one number');
        } else self::msg('Passwords must be at least 10 characters');
        return false;
    }

    public static function genpw()
    {
        return substr(password_hash((string)time(), PASSWORD_DEFAULT), rand(10, 50), 10);
    }

    public static function now($date1, $date2 = null)
    {
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
}
