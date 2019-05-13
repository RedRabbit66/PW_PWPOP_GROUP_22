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



-- Table which'll store the information of the folders
CREATE TABLE folders (
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    hash_id VARCHAR(40) NOT NULL UNIQUE,
    user_id INT(11) UNSIGNED NOT NULL,
    folder_name VARCHAR(255) NOT NULL DEFAULT '',
    root_folder BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id)
		REFERENCES users(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- Table which'll store the information of the subfolders (ImageProfile, Products)
CREATE TABLE subfolders (
    parent_folder INT(11) UNSIGNED NOT NULL,
    child_folder INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY(parent_folder)
		REFERENCES folders(id),
	FOREIGN KEY(child_folder)
		REFERENCES folders(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- Table which'll store the information of the products
CREATE TABLE products (
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    hash_id VARCHAR(40) NOT NULL UNIQUE,
    folder_id INT(11) UNSIGNED NOT NULL,
    file_name VARCHAR(255) NOT NULL DEFAULT '',
    file_path VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY(id),
    FOREIGN KEY(folder_id)
		REFERENCES folders(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

 -- INSERT INTO users(hash_id, name, username, email, birth_date, phone_number, password, profile_image) VALUES('fdsf', 'sergio', 'sergio', 'aa@a.com', '16/6/8755', '666 666 666', 'fxgbgfhnfdgnd', 'aa');
  -- INSERT INTO folders(hash_id, user_id, folder_name, root_folder) VALUES('hhsf', 1, 'aaaa', false);

SELECT * FROM users;
SELECT * FROM folders;

