-- creation DB
DROP DATABASE IF EXISTS loginDB;
CREATE DATABASE loginDB;
USE loginDB;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(12) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    salt VARCHAR(32) NOT NULL,
    email VARCHAR(255),
    accountType ENUM('user', 'admin') NOT NULL,
    registered DATETIME NOT NULL,
    lastlogin DATETIME
);

-- insert test data
INSERT INTO users (username, password_hash, salt, email, accountType, registered) VALUES ('admin','admin', 'salt', 'test@gmail.com', 'admin', NOW());
INSERT INTO users (username, password_hash, salt, email, accountType, registered) VALUES ('test1','test1', 'salt', 'test1@gmail.com', 'user', NOW());
INSERT INTO users (username, password_hash, salt, email, accountType, registered) VALUES ('test2','test2', 'salt', 'test2@gmail.com', 'user', NOW());