<?php
// lib/php/plugins/users.php 20150101 - 20170306
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugins_Users extends Plugin
{
    protected
    $tbl = 'users',
    $in = [
        'userid'    => '',
        'acl'       => 0,
        'fname'     => '',
        'lname'     => '',
        'altemail'  => '',
        'webpw'     => '',
        'otp'       => '',
        'anote'     => '',
    ];
}

?>
