<?php
// lib/php/themes/none/contact.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_None_Contact extends Themes_None_Theme
{
    public function list(array $in) : string
    {
error_log(__METHOD__);

        return $in['buf'];
    }
}

?>
