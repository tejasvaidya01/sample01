DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `updated` datetime NOT NULL,
  `created` datetime NOT NULL
);

INSERT INTO `notes` (`id`, `title`, `content`, `author`, `updated`, `created`) VALUES
(1, 'What does CRUD mean?', 'In computer programming, create, read, update and delete (CRUD) are the four basic functions of persistent storage.', 'admin', datetime('now','localtime'), datetime('now','localtime')),
(2, 'When was it first used?', 'The term was likely first popularized by James Martin in his 1983 book Managing the Data-base Environment.', 'admin', datetime('now','localtime'), datetime('now','localtime'));
