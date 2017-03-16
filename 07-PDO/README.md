## spe/07-PDO

_Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)_

2017-03-16 - Changed the default CRUD plugin class to CRUDL (create, read, update, delete, list.)
The extra list() method replaces read() which switched between the read_one() and read_all(), the
former becomes the new read() and the later became list() instead. This change came about because
of the need for pagination and a clear way to apply an additional pager() method.


TODO: write more
