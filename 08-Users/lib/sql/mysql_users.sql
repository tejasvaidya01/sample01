CREATE DATABASE IF NOT EXISTS spe;
USE spe;
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `acl` tinyint(1) NOT NULL default 0,
  `uid` varchar(31) NOT NULL,
  `fname` varchar(31) NOT NULL,
  `lname` varchar(31) NOT NULL,
  `email` varchar(63) NOT NULL,
  `pwkey` varchar(8) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL
);

ALTER TABLE `users` ADD UNIQUE (`uid`);
ALTER TABLE `users` ADD UNIQUE (`email`);

INSERT INTO `users` (`id`, `acl`, `uid`, `fname`, `lname`, `email`, `pwkey`, `passwd`, `updated`, `created`) VALUES
(1, 127, 'admin', 'System', 'Administrator', 'admin@example.org', '', 'changeme', NOW(), NOW()),
(2, 2, 'user1', 'User', 'One', 'user1@example.org', '', 'changeme', NOW(), NOW());
