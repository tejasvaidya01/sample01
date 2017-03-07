<?php
// lib/php/themes/simple/contact.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_Simple_Contact extends Themes_Simple_Theme
{
    public function read(array $in) : string
    {
error_log(__METHOD__);

        return $in['buf'] . $in['js'];
    }
}

?>
