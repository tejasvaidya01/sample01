#!/bin/bash
# setup.sh 20170306
# Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

DB="lib/.ht_spe.sqlite"

if [[ ! -f $DB ]]; then
    DIR=$(dirname $DB)
    [[ ! -d $DIR ]] && mkdir -p $DIR && chmod 750 $DIR
    cat << EOS | sqlite3 $DB
CREATE TABLE IF NOT EXISTS "news" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "title" text NOT NULL,
  "content" text NOT NULL,
  "author" text NOT NULL,
  "updated" numeric NOT NULL,
  "created" numeric NOT NULL
);
CREATE TABLE IF NOT EXISTS "users" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "acl" integer NOT NULL DEFAULT '0',
  "userid" text NOT NULL,
  "fname" text NOT NULL DEFAULT ' ',
  "lname" text NOT NULL DEFAULT ' ',
  "altemail" text NOT NULL DEFAULT ' ',
  "webpw" text NOT NULL,
  "otp" text NOT NULL,
  "otpttl" integer NOT NULL DEFAULT '0',
  "cookie" text NOT NULL DEFAULT ' ',
  "anote" text NOT NULL DEFAULT ' ',
  "updated" numeric NOT NULL,
  "created" numeric NOT NULL
);
INSERT INTO "news" VALUES(1,'What does CRUD mean?','In computer programming,','admin','2017-02-20 17:14:19','2017-02-12 00:08:45');
INSERT INTO "news" VALUES(2,'When was it first used?','The term was','admin','2017-02-20 17:14:36','2017-02-12 00:08:45');
INSERT INTO "users" VALUES(1,1,'admin@example.org','Sys','Adm','admin@exmaple.com','$2y$10$SwN3X.HFHdkTK8JH07RBWOxKHQ1JeUjCDpM8epozy5Y61OqpAZnbC','',0,'','','2017-03-02 17:54:28','2017-02-21 01:32:00');
INSERT INTO "users" VALUES(2,2,'user1@example.org','User','One','user1@example.com','$2y$10$SwN3X.HFHdkTK8JH07RBWOxKHQ1JeUjCDpM8epozy5Y61OqpAZnbC','',0,'','','2017-02-12 00:08:38','2017-02-12 00:08:38');
EOS
    chmod 600 $DB
    echo "Installed SQLite 'spe' database to $DB"
    #sqlite3 $DB .dump
else
    echo "SQLite database at $DB already exists"
fi
