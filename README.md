# SPE - Simple PHP7 Examples

_Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)_

A very simple PHP7 "framework" that will be expanded to include more small
project examples building on the first very lean foundation and incorporating
additional functionality in each successive example. This is not a repository
of all the attributes of PHP7, there are already many other great projects
and pages that provide excellent PHP7 guides, but rather a series of examples
that are fully developed under PHP7 (sury/php7.0 PPA on Ubuntu 15.10 2015-09)
and taking advantage of any new PHP7-only constructs where it makes sense.
Each folder will contain a more comprehensive example of a working, and
hopefully useful, sub-project with a README.md explaining each example. This
README will provide an overview and index of all examples and some hints that
apply to all the sub-project examples.

- [01-Simple]

  At 90 LOC this is about the simplest 3 page example of this particular
  framework style I could come up with. It is a self-contained single script
  withall code encapsulated within classes.

- [02-Styled]

  Funcionally similar to the above barebones example but with a small amount
  of inline CSS to provide a minimum of style along with the Roboto font from
  Google CDN.

- [03-Plugins]

  A simple example of providing "plugins" which are basically the model of
  the traditional MVC coding style. It also includes a simple AJAX link on
  the About page that dumps the main global output array using the ultra
  simple remote XHR API. There is also an example of passing a success/error
  message back into the same page but it will be replaced with session vars
  in one of the next examples.

- [04-Themes]

  Extend the above example to include basic themeing classes and methods.

- [05-Autoload]

  Add a simple `spl_autoload_register()` function to autoload the split out
  plugin and theme classes.

- [06-Session]

  TODO:

- [07-PDO]

  TODO:

- [08-Users]

  TODO:

- [05-Auth]

  TODO:

- [10-Files]

  TODO:


The associated example README files will act as both code comments and
general documentation for each project and an easy way to follow along is
to open up two browsers side by side with the README documentation on the
left side and drag the reference page line links to the right hand side
browser which will highlight the code being discussed.

![](https://github.com/markc/spe/blob/master/firefox-side-by-side-960x540.jpg)

This function below has proven to be quite useful for examining the code,
assuming you have access to the servers `error_log` file...

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

[01-Simple]:   https://github.com/markc/spe/tree/master/01-Simple/README.md
[02-Styled]:   https://github.com/markc/spe/tree/master/02-Styled/README.md
[03-Plugins]:  https://github.com/markc/spe/tree/master/03-Plugins/README.md
[04-Themes]:   https://github.com/markc/spe/tree/master/04-Themes/README.md
[05-Autoload]: https://github.com/markc/spe/tree/master/05-Autoload/README.md
