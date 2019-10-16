CREATE TABLE `submissions` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `text` text NOT NULL,
  `displayed` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);
