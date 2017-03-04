<?php
// index.php 20150101 - 20170304
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

echo new Init(new class
{
    public
    $self       = '',
    $email      = 'markc@renta.net',
    $in = [
        'l'     => '',          // Log (message)
        'm'     => 'read',      // Method (action)
        'o'     => 'home',      // Object (content)
        't'     => 'bootstrap', // Theme
        'x'     => '',          // XHR (request)
    ],
    $out = [
        'doc'   => 'SPE::04',
        'css'   => '',
        'log'   => '',
        'nav1'  => '',
        'nav2'  => '',
        'head'  => 'Themes',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015-2017 Mark Constable (AGPL-3.0)',
    ],
    $nav1 = [
        ['About',       '?o=about', 'fa fa-info-circle fa-fw'],
        ['Contact',     '?o=contact', 'fa fa-envelope fa-fw'],
    ],
    $nav2 = [
        ['None',        '?t=none'],
        ['Simple',      '?t=simple'],
        ['Bootstrap',   '?t=bootstrap'],
    ];
});

class Init
{
    public function __construct($g)
    {
error_log(__METHOD__);

        $this->g = $g;
        $g->self = str_replace('index.php', '', $_SERVER['PHP_SELF']);

        foreach ($g->in as $k => $v)
            $this->g->in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k])) : $v;

        $p  = 'plugins_' . $g->in['o'];
        $t  = 'themes_' . $g->in['t'] . '_' . $g->in['o'];
        $tt = 'themes_' . $g->in['t'] . '_theme';

        $this->g->t = $thm = class_exists($t) ? new $t($g)
            : (class_exists($tt) ? new $tt($g) : new Theme($g));

        if (class_exists($p)) {
            $plugin = new $p($g);
            if (method_exists($plugin, $g->in['m'])) {
                $g->out['main'] = (string) $plugin->{$g->in['m']}();
            } else $g->out['main'] = "Error: no plugin method!";
        } else $g->out['main'] = "Error: no plugin object!";

        foreach ($g->out as $k => $v)
            $g->out[$k] = method_exists($thm, $k) ? $thm->$k() : $v;

    }

    public function __toString() : string
    {
error_log(__METHOD__);

        if ($this->g->in['x']) {
            $xhr = $this->g->out[$this->g->in['x']] ?? '';
            if ($xhr) return $xhr;
            header('Content-Type: application/json');
            return json_encode($this->g->out, JSON_PRETTY_PRINT);
        }
        return $this->g->t->html();
    }
}

class Theme
{
    private
    $buf = '',
    $in  = [];

    public function __construct($g)
    {
error_log(__METHOD__);

        $this->g = $g;
    }

    public function __toString() : string
    {
error_log(__METHOD__);

        return $this->buf;
    }

    public function log() : string
    {
error_log(__METHOD__);

        if ($this->g->in['l']) {
            list($lvl, $msg) = explode(':', $this->g->in['l']);
            return '
      <p class="alert ' . $lvl . '">' . $msg . '</p>';
        }
        return '';
    }

    public function nav1() : string
    {
error_log(__METHOD__);

        $m = '?m='.$this->g->in['m'];
        return '
      <nav>' . join('', array_map(function ($n) use ($m) {
            $c = $m === $n[1] ? ' class="active"' : '';
            return '
        <a' . $c . ' href="' . $n[1] . '">' . $n[0] . '</a>';
        }, $this->g->nav1)) . '
      </nav>';
    }

    public function head() : string
    {
error_log(__METHOD__);

        return '
    <header>
      <h1>' . $this->g->out['head'] . '</h1>' . $this->g->out['nav1'] . '
    </header>';
    }

    public function main() : string
    {
error_log(__METHOD__);

        return '
    <main>' . $this->g->out['main'] . '
    </main>';
    }

    public function foot() : string
    {
error_log(__METHOD__);

        return '
    <footer>
      <p><em><small>' . $this->g->out['foot'] . '</small></em></p>
    </footer>';
    }

    public function html() : string
    {
error_log(__METHOD__);

        extract($this->g->out, EXTR_SKIP);
        return '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . $doc . '</title>' . $css . '
  </head>
  <body>' . $head . $log . $main . $foot . '
  </body>
</html>
';
    }
}

class Plugin
{
    private
    $buf = '',
    $in  = [];

    public function __construct($g)
    {
error_log(__METHOD__);

        $this->g = $g;
    }

    public function __toString() : string
    {
error_log(__METHOD__);

        return $this->buf;
    }

    public function create() : string
    {
error_log(__METHOD__);

        return "Plugin::create() not implemented yet!";
    }

    public function read() : string
    {
error_log(__METHOD__);

        return "Plugin::read() not implemented yet!";
    }

    public function update() : string
    {
error_log(__METHOD__);

        return "Plugin::update() not implemented yet!";
    }

    public function delete() : string
    {
error_log(__METHOD__);

        return "Plugin::delete() not implemented yet!";
    }

}

class Plugins_Home extends Plugin
{
    public function read() : string
    {
error_log(__METHOD__);

        $this->g->nav1 = array_merge($this->g->nav1, [
            ['Project Page', 'https://github.com/markc/spe/tree/master/02-Styled'],
            ['Issue Tracker', 'https://github.com/markc/spe/issues'],
        ]);
        return '
      <h2>Home</h2>
      <p>
This is an ultra simple single-file PHP7 framework and template system example.
Comments and pull requests are most welcome via the Issue Tracker link above.
      </p>';
    }
}

class Plugins_About extends Plugin
{
    public function read() : string
    {
error_log(__METHOD__);

        return '
      <h2>About</h2>
      <p>
This is an example of a simple PHP7 "framework" to provide the core
structure for further experimental development with both the framework
design and some of the new features of PHP7.
      </p>
      <form method="post">
        <p>
          <a class="btn success" href="?o=about&l=success:Howdy, all is okay.">Success Message</a>
          <a class="btn danger" href="?o=about&l=danger:Houston, we have a problem.">Danger Message</a>
          <a class="btn" href="#" onclick="ajax(\'1\')">JSON</a>
          <a class="btn" href="#" onclick="ajax(\'\')">HTML</a>
          <a class="btn" href="#" onclick="ajax(\'foot\')">FOOT</a>
        </p>
      </form>
      <pre id="dbg"></pre>
      <script>
function ajax(a) {
  if (window.XMLHttpRequest)  {
    var x = new XMLHttpRequest();
    x.open("POST", "", true);
    x.onreadystatechange = function() {
      if (x.readyState == 4 && x.status == 200) {
        document.getElementById("dbg").innerHTML = x.responseText
          .replace(/</g,"&lt;")
          .replace(/>/g,"&gt;")
          .replace(/\\\n/g,"\n")
          .replace(/\\\/g,"");
    }}
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    x.send("o=about&x="+a);
    return false;
  }
}
      </script>';
    }
}

class Plugins_Contact extends Plugin
{
    public function read() : string
    {
error_log(__METHOD__);

        return '
      <h2>Email Contact Form</h2>
      <form id="contact-send" method="post" onsubmit="return mailform(this);">
        <p><input id="subject" required="" type="text" placeholder="Message Subject"></p>
        <p><textarea id="message" rows="9" required=""placeholder="Message Content"></textarea></p>
        <p class="rhs">
          <small>(Note: Doesn\'t seem to work with Firefox 50.1)</small>
          <input class="btn" type="submit" id="send" value="Send">
        </p>
      </form>
      <script>
function mailform(form) {
    location.href = "mailto:' . $this->g->email . '"
        + "?subject=" + encodeURIComponent(form.subject.value)
        + "&body=" + encodeURIComponent(form.message.value);
    form.subject.value = "";
    form.message.value = "";
    alert("Thank you for your message. We will get back to you as soon as possible.");
    return false;
}
      </script>';
    }
}

class Themes_None_Theme extends Theme {}

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
    max-width: 42rem;
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
nav a:hover, button:hover, input[type="submit"]:hover, .btn:hover  {
    background-color: #0275d8;
    color: #fff;
    text-decoration: none;
}
label, input[type="text"], textarea, pre {
    display: inline-block;
    width: 100%;
    padding: 0.5em;
    font-size: 1rem;
    box-sizing : border-box;
}
p, pre, ul { margin-top: 0; }
a:link, a:visited { color: #0275d8; text-decoration: none; }
a:hover { text-decoration: underline; }
a.active { background-color: #2295f8; color: #ffffff; }
a.active:hover { background-color: #2295f8; }
.rhs { text-align: right; }
.center { text-align: center; }
.alert { padding: 0.5em; text-align: center; border-radius: 0.2em; }
.success { background-color: #dff0d8; border-color: #d0e9c6; color: #3c763d; }
.danger { background-color: #f2dede; border-color: #ebcccc; color: #a94442; }
@media (max-width: 46rem) { body { width: 92%; } }
        </style>';
    }
}

class Themes_Bootstrap_Theme extends Theme
{
    public function css() : string
    {
error_log(__METHOD__);

        return '
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,300italic" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" rel="stylesheet" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <style>
* { transition: 0.2s linear; }
body {
  font-family: "Roboto", sans-serif;
  font-size: 17px;
  font-weight: 300;
  padding-top: 5rem;
}
.w100 { width: 100px; }
.w200 { width: 200px; }
.w300 { width: 300px; }

.min50  { min-width:  50px; }
.min100 { min-width: 100px; }
.min150 { min-width: 150px; }
.min200 { min-width: 200px; }
.min300 { min-width: 300px; }
.min400 { min-width: 400px; }
.min500 { min-width: 500px; }
.min600 { min-width: 600px; }

.nowrap { white-space: nowrap; }
    </style>';
    }

    public function log() : string
    {
error_log(__METHOD__);

        if ($this->g->in['l']) {
            list($lvl, $msg) = explode(':', $this->g->in['l']);
            return $msg ? '
      <div class="alert alert-' . $lvl . '">' . $msg . '
      </div>' : '';
        } else return '';
    }

    public function head() : string
    {
error_log(__METHOD__);

        return '
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="' . $this->g->self . '"><b>' . $this->g->out['head'] . '</b></a>
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">' . $this->g->out['nav1'] . '
        </ul>
      </div>
    </nav>';
    }

    public function nav1(array $a = []) : string
    {
error_log(__METHOD__);

//        $a = isset($a[0]) ? $a : util::which_usr($this->g->nav1);
        $a = isset($a[0]) ? $a : $this->g->nav1;
        $o = '?o=' . $this->g->in['o'];
        $t = '?t=' . $this->g->in['t'];
        return join('', array_map(function ($n) use ($o, $t) {
            if (is_array($n[1])) return $this->nav_dropdown($n);
            $c = $o === $n[1] || $t === $n[1] ? ' active' : '';
            $i = isset($n[2]) ? '<i class="' . $n[2] . '"></i> ' : '';
            return '
          <li class="nav-item' . $c . '"><a class="nav-link" href="' . $n[1] . '">' . $i . $n[0] . '</a></li>';
        }, $a));
    }

    public function nav_dropdown(array $a = []) : string
    {
error_log(__METHOD__);

        $o = '?o=' . $this->g->in['o'];
        $i = isset($a[2]) ? '<i class="' . $a[2] . '"></i> ' : '';
        return '
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $i . $a[0] . '</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">'.join('', array_map(function ($n) use ($o) {
            $c = $o === $n[1] ? ' active' : '';
            $i = isset($n[2]) ? '<i class="' . $n[2] . '"></i> ' : '';
            return '
              <a class="dropdown-item" href="' . $n[1] . '">' . $i . $n[0] . '</a>';
        }, $a[1])).'
            </div>
          </li>';
    }

    public function main() : string
    {
error_log(__METHOD__);

        return '
    <main class="container">
      <div class="row">
        <div class="col-12">' . $this->g->out['log'] . $this->g->out['main'] . '
        </div>
      </div>
    </main>';
    }

}




function dbg($var = null)
{
    if (is_object($var))
        error_log(ReflectionObject::export($var, true));
    ob_start();
    print_r($var);
    $ob = ob_get_contents();
    ob_end_clean();
    error_log($ob);
}

