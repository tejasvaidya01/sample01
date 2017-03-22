#!/bin/bash
# setup-mysql.sh 20170319 - 20170319
# Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

# First create DBNAME and allow DBUSER access with DBPASS in lib/.ht_pw

DBNAME="spe_08"
DBUSER="sysadm"
DBHOST="localhost"
DBPASS=""

[[ -f lib/.ht_pw ]] && DBPASS=$(< lib/.ht_pw)

MYSQL="mysql -h $DBHOST -u $DBUSER -p$DBPASS $DBNAME"

cat << 'EOS' | $MYSQL
CREATE TABLE `news` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `author` integer NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL
);
CREATE TABLE IF NOT EXISTS `users` (
  `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `grp` integer NOT NULL DEFAULT '0',
  `acl` integer NOT NULL DEFAULT '0',
  `login` varchar(64) NOT NULL,
  `fname` varchar(64) NOT NULL DEFAULT '',
  `lname` varchar(64) NOT NULL DEFAULT '',
  `altemail` varchar(64) NOT NULL DEFAULT '',
  `webpw` varchar(64) NOT NULL DEFAULT '',
  `otp` varchar(64) NOT NULL DEFAULT '',
  `otpttl` integer NOT NULL DEFAULT '0',
  `cookie` varchar(64) NOT NULL DEFAULT '',
  `anote` text NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL
);
INSERT INTO `news` VALUES
(null, 'News Item 1', 'Lorem ipsum etc...', 0, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 2', 'Lorem ipsum etc...', 0, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 3', 'Lorem ipsum etc...', 1, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 4', 'Lorem ipsum etc...', 1, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 5', 'Lorem ipsum etc...', 2, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 6', 'Lorem ipsum etc...', 2, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 7', 'Lorem ipsum etc...', 3, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 8', 'Lorem ipsum etc...', 3, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 9', 'Lorem ipsum etc...', 4, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 10', 'Lorem ipsum etc...', 4, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 11', 'Lorem ipsum etc...', 5, '2017-02-20 17:14:36', '2017-02-12 00:08:45'),
(null, 'News Item 12', 'Lorem ipsum etc...', 5, '2017-02-20 17:14:36', '2017-02-12 00:08:45');
INSERT INTO `users` VALUES
(null,0,0,'sysadm@example.org','Sys','Adm','','','',0,'','','2017-03-02 17:54:28','2017-02-21 01:32:00'),
(null,0,2,'user1@example.org','User','One','','','',0,'','','2017-02-12 00:08:38','2017-02-12 00:08:38'),
(null,0,2,'user2@example.org','User','Two','','','',0,'','','2017-02-12 00:08:38','2017-02-12 00:08:38'),
(null,0,1,'admin1@example.org','Admin','One','','','',0,'','','2017-02-12 00:08:38','2017-02-12 00:08:38'),
(null,1,2,'user3@example.org','User','Three','','','',0,'','','2017-02-12 00:08:38','2017-02-12 00:08:38'),
(null,1,2,'user4@example.org','User','Four','','','',0,'','','2017-02-12 00:08:38','2017-02-12 00:08:38');
EOS

echo "Installed MySQL 'users' database"
