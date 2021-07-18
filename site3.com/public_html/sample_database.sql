CREATE DATABASE IF NOT EXISTS s3db;
CREATE USER IF NOT EXISTS 'd3user'@'localhost' IDENTIFIED BY 'd3user';
GRANT ALL PRIVILEGES ON s3db.* TO 'd3user'@'localhost';
FLUSH PRIVILEGES;

use s3db;

CREATE TABLE `pm` (
                      `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      `title` varchar(256) NOT NULL,
                      `sender` varchar(50) NOT NULL,
                      `receiver` varchar(50) NOT NULL,
                      `message` text NOT NULL,
                      `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
                         `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                         `username` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users` (`username`, `password`) VALUES ('admin', 'hard_to_bruteforce');
