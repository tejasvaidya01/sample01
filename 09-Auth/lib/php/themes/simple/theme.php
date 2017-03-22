<?php
// lib/php/themes/simple/theme.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_Simple_Theme extends Theme
{
    public function css() : string
    {
error_log(__METHOD__);

        return '
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,300italic" rel="stylesheet" type="text/css">
    <style>
* { transition: 0.25s linear; }
body {
    background-color: #fff;
    color: #444;
    font-family: "Roboto", sans-serif;
    font-weight: 300;
    height: 50rem;
    line-height: 1.5;
    margin: 0 auto;
    max-width: 50rem;
}
h1, h2, h3, nav, footer {
    color: #0275d8;
    font-weight: 300;
    text-align: center;
    margin: 0.5rem 0;
}
nav a, .btn {
    background-color: #ffffff;
    border-radius: 0.2em;
    border: 0.01em solid #0275d8;
    display: inline-block;
    padding: 0.25em 1em;
    font-family: "Roboto", sans-serif;
    font-weight: 300;
    font-size: 1rem;
}
nav a:hover, button:hover, input[type="submit"]:hover, .btn:hover, .bg-primary  {
    background-color: #0275d8;
    color: #fff;
    text-decoration: none;
}
label, input[type="text"], input[type="email"], input[type="password"], textarea, pre {
    display: inline-block;
    width: 100%;
    padding: 0.5em;
    font-size: 1rem;
    box-sizing : border-box;
}
form { margin: 0 auto; width: 36rem; }
p, pre, ul { margin-top: 0; }
a:link, a:visited { color: #0275d8; text-decoration: none; }
a:hover { text-decoration: underline; }
a.active { background-color: #2295f8; color: #ffffff; }
a.active:hover { background-color: #2295f8; }
table { width: 100%; }
table td { padding: 0.25em 1em; }
.w100 { width: 100px; }
.w150 { width: 150px; }
.w200 { width: 200px; }
.text-right { text-align: right; }
.text-center { text-align: center; }
.alert { padding: 0.5em; text-align: center; border-radius: 0.2em; }
.success, .btn-success { background-color: #dff0d8; border-color: #d0e9c6; color: #3c763d; }
.danger, .btn-danger { background-color: #f2dede; border-color: #ebcccc; color: #a94442; }
.tblbg { background-color: #efefef; }
.top { vertical-align:  top; }
@media (max-width: 46rem) { body { width: 92%; } }
        </style>';
    }
}

?>
