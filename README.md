DROP DATABASE IF EXISTS pwpopdb; 

CREATE DATABASE pwpopdb;

USE pwpopdb;

DROP TABLE IF EXISTS users; CREATE TABLE users ( id INT(20) UNSIGNED NOT NULL AUTO_INCREMENT, hash_id VARCHAR(100) NOT NULL UNIQUE, name VARCHAR(100) NOT NULL DEFAULT '', username VARCHAR(100) NOT NULL UNIQUE, email VARCHAR(100) NOT NULL UNIQUE, birth_date VARCHAR(100) NOT NULL DEFAULT '', phone_number VARCHAR(100) NOT NULL DEFAULT '', password VARCHAR(150) NOT NULL DEFAULT '', profile_image VARCHAR(150) NOT NULL DEFAULT '',

PRIMARY KEY(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


-- Table which'll store the information of the products 

CREATE TABLE products ( id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, hash_id VARCHAR(40) NOT NULL UNIQUE, user_id INT(20) UNSIGNED NOT NULL, description VARCHAR(255) NOT NULL DEFAULT '', datetime datetime NOT NULL, price INT(10) NOT NULL DEFAULT 0, category VARCHAR(50) NOT NULL DEFAULT '', file_name VARCHAR(255) NOT NULL DEFAULT '', sold_out BOOLEAN DEFAULT FALSE, file_path VARCHAR(255) NOT NULL DEFAULT '', PRIMARY KEY(id) ) ENGINE = InnoDB DEFAULT CHARSET = utf8;


-- INSERT INTO users(hash_id, name, username, email, birth_date, phone_number, password, profile_image) VALUES('fdsf', 'sergio', 'sergio', 'aa@a.com', '16/6/8755', '666 666 666', 'fxgbgfhnfdgnd', 'aa'); 

-- INSERT INTO folders(hash_id, user_id, folder_name, root_folder) VALUES('hhsf', 1, 'aaaa', false);

-- INSERT INTO products(hash_id, user_id, description, datetime, price, category, file_name, file_path) VALUES('hash1', 1, "llure desc", NOW(), 200, 1, 'llorenc', 'llure.jpg');

--INSERT INTO products(hash_id, user_id, description, datetime, price, category, file_name, file_path) VALUES('hash2', 1, "llure2 desc", NOW(), 200, 1, 'llorenc2', 'llure2.jpg');

--INSERT INTO products(hash_id, user_id, description, datetime, price, category, file_name, file_path) VALUES('hash3', 1, "llure3 desc", NOW(), 200, 1, 'llorenc3', 'llure2.jpg');
--INSERT INTO products(hash_id, user_id, description, datetime, price, category, file_name, file_path) VALUES('hash4', 1, "llure4 desc", NOW(), 200, 1, 'llorenc4', 'llure2.jpg');
--INSERT INTO products(hash_id, user_id, description, datetime, price, category, file_name, file_path) VALUES('hash5', 1, "llure5 desc", NOW(), 200, 1, 'llorenc5', 'llure2.jpg');
--INSERT INTO products(hash_id, user_id, description, datetime, price, category, file_name, file_path) VALUES('hash6', 1, "llure6 desc", NOW(), 200, 1, 'llorenc6', 'llure2.jpg');

SELECT * FROM users; SELECT * FROM folders;