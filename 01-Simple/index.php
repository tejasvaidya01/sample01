<?php
// index.php 20150101 - 20170302
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)
// Documentation added by Tejas Vaidya

/**
*	Class object is created and printed with echo
*/
echo new class
{
    /**
    *	These are private variable arrays($in, $out and $nav1), Only accessible within the class.
    *	$in defines request parameters with default values.
    *	$out defines various html regions.
    *	$nav1 defines navigation menu links with request parameters
    */
    private
    $in = [
        'm'     => 'home',      // Method action
    ],
    $out = [
        'doc'   => 'SPE::01',
        'nav1'  => '',
        'head'  => 'Simple',
        'main'  => '<p>Error: missing page!</p>',
        'foot'  => 'Copyright (C) 2015-2017 Mark Constable (AGPL-3.0)',
    ],
    $nav1 = [
        ['Home', '?m=home'],
        ['About', '?m=about'],
        ['Contact', '?m=contact'],
    ];

    /**
    *	This function is called when the class object is created.
    *	It defines variables and methods.
    *	method_exists() checks if in['m'] is exists within this class.
    *	If request parameter does not exists then home output is set by default
    *	Also checks if output methods exists and call those, else set default values from $out
    */
    public function __construct()
    {
        $this->in['m'] = $_REQUEST['m'] ?? $this->in['m'];
        if (method_exists($this, $this->in['m']))
            $this->out['main'] = $this->{$this->in['m']}();
        foreach ($this->out as $k => $v)
            $this->out[$k] = method_exists($this, $k) ? $this->$k() : $v;
    }

    /**
    *	This function is called after __construct function.
    *	It converts the output to the string.
    *	It calls private function html() of the same class.
    */
    public function __toString() : string
    {
        return $this->html();
    }

    /**
    *	Navigation menu is created.
    *	For each menu in $nav a link is created and then joined together.
    */
    private function nav1() : string
    {
        return '
      <nav>' . join('', array_map(function ($n) {
            return '
        <a href="' . $n[1] . '">' . $n[0] . '</a>';
        }, $this->nav1)) . '
      </nav>';
    }

    /**
    *	Returns output for the header region.
    */
    private function head() : string
    {
        return '
    <header>
      <h1>' . $this->out['head'] . '</h1>' . $this->out['nav1'] . '
    </header>';
    }

    /**
    *	Returns output for the main region.
    */
    private function main() : string
    {
        return '
    <main>' . $this->out['main'] . '
    </main>';
    }

    /**
    *	Returns output for the footer region.
    */
    private function foot() : string
    {
        return '
    <footer>
      <p><em><small>' . $this->out['foot'] . '</small></em></p>
    </footer>';
    }

    /**
    *	This converts the output into a string.
	*	extract creates local variables for for every entry in $out array.
	*	HTML page is created here with all regions.
    */
    private function html() : string
    {
        extract($this->out, EXTR_SKIP);
        return '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . $doc . '</title>
  </head>
  <body>' . $head . $main . $foot . '
  </body>
</html>
';
    }

    /**
    *	Creates the content for each page of the navigation.
    *	Called from the __construct to set output of the main region
    */
    private function home() { return '<h2>Home Page</h2><p>Lorem ipsum home.</p>'; }
    private function about() { return '<h2>About Page</h2><p>Lorem ipsum about.</p>'; }
    private function contact() { return '<h2>Contact Page</h2><p>Lorem ipsum contact.</p>'; }
};
