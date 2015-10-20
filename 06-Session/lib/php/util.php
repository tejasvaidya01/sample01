<?php
// util.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Util
{
    public static function msg(string $msg = '', string $lvl = 'danger') : array
    {
        if ($_SESSION['msg']) {
            $l = $_SESSION['lvl']; $_SESSION['lvl'] = '';
            $m = $_SESSION['msg']; $_SESSION['msg'] = '';
            return [$l, $m];
        } elseif ($msg) {
            $_SESSION['msg'] = $msg;
            $_SESSION['lvl'] = $lvl;
        }
        return ['', ''];
    }
}
