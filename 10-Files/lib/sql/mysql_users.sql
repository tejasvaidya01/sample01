CREATE DATABASE IF NOT EXISTS spe;
USE spe;
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `acl` tinyint(1) NOT NULL default 0,
  `uid` varchar(31) NOT NULL,
  `fname` varchar(31) NOT NULL,
  `lname` varchar(31) NOT NULL,
  `altemail` varchar(63) NOT NULL,
  `webpw` varchar(255) NOT NULL,
  `otp` varchar(8) NOT NULL,
  `otpttl` int(10) NOT NULL,
  `cookie` varchar(255) NOT NULL,
  `anote` text NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL
);

ALTER TABLE `users` ADD UNIQUE (`uid`);

INSERT INTO `users` (`id`, `acl`, `uid`, `fname`, `lname`, `altemail`, `webpw`, `otp`, `otpttl`, `cookie`, `anote`, `updated`, `created`) VALUES
(1, 1, 'admin@example.org', 'System', 'Administrator', 'admin@example.com', '$2y$10$SwN3X.HFHdkTK8JH07RBWOxKHQ1JeUjCDpM8epozy5Y61OqpAZnbC', '', '', '', '', NOW(), NOW()),
(2, 2, 'user1@example.org', 'User', 'One', 'user1@example.com', '$2y$10$SwN3X.HFHdkTK8JH07RBWOxKHQ1JeUjCDpM8epozy5Y61OqpAZnbC', '', '', '', '', NOW(), NOW()),
(3, 2, 'user2@example.org', 'User', 'Two', 'user2@example.com', '$2y$10$SwN3X.HFHdkTK8JH07RBWOxKHQ1JeUjCDpM8epozy5Y61OqpAZnbC', '', '', '', '', NOW(), NOW());
