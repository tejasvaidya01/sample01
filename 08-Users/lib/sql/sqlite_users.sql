DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `acl` tinyint(1) NOT NULL default 0,
  `uid` varchar(31) NOT NULL,
  `fname` varchar(31) NOT NULL,
  `lname` varchar(31) NOT NULL,
  `email` varchar(63) NOT NULL,
  `pwkey` varchar(8) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `anote` text NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL
);

CREATE UNIQUE INDEX `uid_UNIQUE` ON `users` (`uid` ASC);
CREATE UNIQUE INDEX `email_UNIQUE` ON `users` (`email` ASC);

INSERT INTO `users` (`id`, `acl`, `uid`, `fname`, `lname`, `email`, `pwkey`, `passwd`, `anote`, `updated`, `created`) VALUES
(1, 127, 'admin', 'System', 'Administrator', 'admin@example.org', '', 'changeme', '', datetime('now', 'localtime'), datetime('now', 'localtime')),
(2, 2, 'user1', 'User', 'One', 'user1@example.org', '', 'changeme', '', datetime('now', 'localtime'), datetime('now', 'localtime'));

