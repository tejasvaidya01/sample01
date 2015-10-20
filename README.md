# simple-php7-examples

**2015-10-15** -- _Copyright (C) 2015 Mark Constable (AGPL-3.0)_

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

- [01-Simplest]

  At 132 LOC this is about the simplest 3 page example of this particular
  framework I could come up with. It is a self-contained single script with
  all code encapsulated within classes.

- [02-Styled]

  Funcionally similar to the above barebones example but with a reasonable
  stylesheet (2.4K 130 sloc) and the Roboto font from Google CDN. It also
  includes a simple AJAX link on the About page that dumps the main global
  output array using the ultra simple remote API. There is also an example
  of passing a success/error message back into the same page but it will be
  replaced with session vars in one of the next examples.

- [03-MVC]

  Split up the basic functionality of the previous Styled example into the
  three traditional model, view, controller (MVC) classes.

- [04-Autoload]

  Add a simple `spl_autoload_register()` function to autoload the split out
  MVC classes.

- [05-Themes]

  Extend the above example to include basic themeing classes and methods.

The associated example README files will act as both code comments and
general documentation for each project and an easy way to follow along is
to open up two browsers side by side with the README documentation on the
left side and drag the reference page line links to the right hand side
browser which will highlight the code being discussed.

![](https://github.com/markc/simple-php7-examples/blob/master/lib/img/firefox-side-by-side-960x540.jpg)

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

[01-Simplest]: https://github.com/markc/simple-php7-examples/tree/master/01-Simplest/README.md
[02-Styled]: https://github.com/markc/simple-php7-examples/tree/master/02-Styled/README.md
[03-MVC]: https://github.com/markc/simple-php7-examples/tree/master/03-MVC/README.md
[04-Autoload]: https://github.com/markc/simple-php7-examples/tree/master/04-Autoload/README.md
[05-themes]: https://github.com/markc/simple-php7-examples/tree/master/05-Themes/README.md
