#!/bin/bash
# setup-mysql.sh 20170319 - 20170319
# Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

# First create DBNAME and allow DBUSER access with DBPASS in lib/.ht_pw

DBNAME="spe_07"
DBUSER="sysadm"
DBHOST="localhost"
DBPASS=""

[[ -f lib/.ht_pw ]] && DBPASS=$(< lib/.ht_pw)

MYSQL="mysql -h $DBHOST -u $DBUSER -p$DBPASS $DBNAME"

cat << 'EOS' | $MYSQL
CREATE TABLE `news` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `author` text NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL
);
INSERT INTO `news` VALUES
(null, 'News Item 1', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 2', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 3', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 4', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 5', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 6', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 7', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 8', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 9', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 10', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 11', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 12', 'Lorem ipsum etc...', 'admin', '2017-02-20 17:14:36', '2017-02-12 00:08:45');
EOS

echo "Installed MySQL 'news' database"
