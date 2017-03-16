#!/bin/bash
# setup.sh 20170306
# Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

DB="lib/.ht_news.sqlite"

if [[ ! -f $DB ]]; then
    DIR=$(dirname $DB)
    mkdir -p $DIR
    cat << 'EOS' | sqlite3 $DB
CREATE TABLE IF NOT EXISTS "news" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "title" text NOT NULL,
  "content" text NOT NULL,
  "author" text NOT NULL,
  "updated" numeric NOT NULL,
  "created" numeric NOT NULL
);
INSERT INTO "news" VALUES(0,'News Item 0','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(1,'News Item 1','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(2,'News Item 2','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(3,'News Item 3','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(4,'News Item 4','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(5,'News Item 5','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(6,'News Item 6','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(7,'News Item 7','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(8,'News Item 8','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(9,'News Item 9','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(10,'News Item 10','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(11,'News Item 11','Lorem ipsum etc...','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
EOS
    chown $(stat -c "%u:%g" $(pwd)) -R $DIR
    chmod 750 $DIR
    chmod 600 $DB
    echo "Installed SQLite 'news' database to $DB"
fi
