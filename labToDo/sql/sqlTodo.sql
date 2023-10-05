CREATE DATABASE IF NOT EXISTS managetodo
CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE managetodo;

CREATE TABLE IF NOT EXISTS todos (
   todoid INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   userid INT,
   task VARCHAR(255) NOT NULL,
   completed TINYINT DEFAULT 0 COMMENT '0: not complete, 1: completed',
   created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   updated TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;