<?php

return '
      <h2>About</h2>
      <p>
This is an example of a simple PHP7 "framework" to provide the core
structure for further experimental development with both the framework
design and some of the new features of PHP7.
      </p>
      <form method="post">
        <p>
          <a class="btn success" href="?p=about&m=success:Howdy, all is okay.">Success Message</a>
          <a class="btn danger" href="?p=about&m=danger:Houston, we have a problem.">Danger Message</a>
          <a class="btn" href="#" onclick="ajax()">API Debug</a>
        </p>
      </form>
      <pre id="dbg"></pre>
      <script>
function ajax() {
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
    x.send("?p=about&a=json");
    return false;
  }
}
      </script>';
