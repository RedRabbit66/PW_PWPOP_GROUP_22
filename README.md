# PW_PWPOP_GROUP_22

#Script MySQL

DROP DATABASE IF EXISTS pwpopdb;
CREATE DATABASE pwpopdb;

USE pwpopdb;



DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    hash_id VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL DEFAULT '',
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    birth_date VARCHAR(100) NOT NULL DEFAULT '',
    phone_number VARCHAR(100) NOT NULL DEFAULT '',
    password VARCHAR(150) NOT NULL DEFAULT '',
    profile_image VARCHAR(150) NOT NULL DEFAULT '',

    PRIMARY KEY(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- INSERT INTO users(hash_id, name, username, email, birth_date, phone_number, password, profile_image) VALUES('fdsf', 'sergio', 'sergio', 'aa@a.com', '16/6/8755', '666 666 666', 'fxgbgfhnfdgnd', 'aa');

SELECT * FROM users;
