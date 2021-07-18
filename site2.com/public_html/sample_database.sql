CREATE DATABASE IF NOT EXISTS s2db;
CREATE USER IF NOT EXISTS 'd2user'@'localhost' IDENTIFIED BY 'd2user';
GRANT ALL PRIVILEGES ON s2db.* TO 'd2user'@'localhost';
FLUSH PRIVILEGES;

use s2db;

CREATE TABLE users (
                       id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                       username varchar(50) NOT NULL,
                       password varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE news (
                      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      title varchar(50) NOT NULL UNIQUE,
                      author varchar(50) NOT NULL,
                      content text NOT NULL,
                      date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE flag (
                      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      secret varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO users (username, password) VALUES ('admin', 'admin');

INSERT INTO news (title, author, content) VALUES
('First news', 'admin', 'This is a really interesting post.'),
('Second news', 'admin', 'This is a fascinating post!'),
('Third news', 'admin', 'This is a very informative post.');

INSERT INTO flag (secret) VALUES ('hard_to_find');