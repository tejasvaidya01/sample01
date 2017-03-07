<?php
// lib/php/plugins/about.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Plugins_About extends Plugin
{
    public function read() : string
    {
error_log(__METHOD__);

        $buf = '
      <h2>About</h2>
      <p>
This is an example of a simple PHP7 "framework" to provide the core
structure for further experimental development with both the framework
design and some of the new features of PHP7.
      </p>
      <p class="text-center">
        <a class="btn btn-success" href="?o=about&l=success:Howdy, all is okay.">Success Message</a>
        <a class="btn btn-danger" href="?o=about&l=danger:Houston, we have a problem.">Danger Message</a>
      </p>
      <p class="text-center">
        <a class="btn btn-secondary" href="" onclick="ajax(\'1\');return false;">JSON</a>
        <a class="btn btn-secondary" href="" onclick="ajax(\'\');return false;">HTML</a>
        <a class="btn btn-secondary" href="" onclick="ajax(\'foot\');return false;">FOOT</a>
      </p>
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
  }
}
      </script>';
        return $this->t->read(['buf' => $buf]);
    }
}

?>
