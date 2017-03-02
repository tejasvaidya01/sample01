## simple-php7-examples/01-Simplest

**2015-10-15** -- _Copyright (C) 2015 Mark Constable (AGPL-3.0)_

This is the first and simplest project example that demonstrates the core
"framework" structure for this project series. I hesitate to call this
script a "framework" because it's an insult to the likes of Laravel, Zend
and other real frameworks but nonetheless the technique outlined here can
be expanded upon to create far more complex projects so it is indeed a
framework and just about the simplest so-called framework I am aware of.
So let's call it a framework instead of a "framework".

We start off on line [5] with a new PHP7 only declaration of `stict_types`
for this file. Unlike previous versions of PHP, this forces strict type
checking on `int`, `float`, `string`, `bool` and class types for function
and method arguments as well as the return type. Line [7] starts the most
important part of the framework. It has 3 components...

- it contains the only `echo` statement for the entire framework. All output
  to the browser or command line is encapsulated in methods and returned
  as strings and amalgamated to the global `$out` array. There is no "raw"
  (outside of a method or function) code allowed let alone any line by line
  echo statements.

**TODO: complete documentation.**

[5]: https://github.com/markc/simple-php7-examples/blob/master/01-Simplest/index.php#L5
[7]: https://github.com/markc/simple-php7-examples/blob/master/01-Simplest/index.php#L7
