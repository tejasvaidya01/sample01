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
INSERT INTO "news" VALUES(1,'What does CRUD mean?','In computer programming,','admin','2017-02-20 17:14:19','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(2,'When was it first used?','The term was','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
EOS
    chown $(stat -c "%u:%g" $(pwd)) -R $DIR
    chmod 750 $DIR
    chmod 600 $DB
    echo "Installed SQLite 'news' database to $DB"
fi
