CREATE DATABASE IF NOT EXISTS s1db;
CREATE USER IF NOT EXISTS 'd1user'@'localhost' IDENTIFIED BY 'd1user';
GRANT ALL PRIVILEGES ON s1db.* TO 'd1user'@'localhost';
FLUSH PRIVILEGES;

use s1db;

CREATE TABLE users (
                       id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                       username varchar(50) NOT NULL,
                       password varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
