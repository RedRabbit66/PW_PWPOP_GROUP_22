

-- Table which'll store the information of the products 
DROP TABLE IF EXISTS products; 
CREATE TABLE products ( 
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
	hash_id VARCHAR(40) NOT NULL UNIQUE, 
	user_id VARCHAR(100) NOT NULL, 
    description VARCHAR(255) NOT NULL DEFAULT '', 
	dateUpload DATETIME DEFAULT CURRENT_TIMESTAMP , 
	price INT(10) NOT NULL DEFAULT 0,
	category VARCHAR(50) NOT NULL DEFAULT '', 
	title VARCHAR(255) NOT NULL DEFAULT '', 
	product_image VARCHAR(255) NOT NULL DEFAULT '', 
	sold_out BOOLEAN DEFAULT FALSE,
	is_active BOOLEAN DEFAULT TRUE,
	PRIMARY KEY(id) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


-- INSERT INTO users(hash_id, name, username, email, birth_date, phone_number, password, profile_image) VALUES('fdsf', 'sergio', 'sergio', 'aa@a.com', '16/6/8755', '666 666 666', 'fxgbgfhnfdgnd', 'aa'); 


   INSERT INTO products(hash_id, user_id, description, dateUpload, price, category, title, product_image) VALUES('aaa', '2', "llure3 desc", NOW(), 200, 2, 'ddddd','llure.jpg');
    INSERT INTO products(hash_id, user_id, description, dateUpload, price, category, title, product_image) VALUES('haffsh4', '1', "llure4 desc", NOW(), 200, 1, 'llorenc4','llure2.jpg');
   INSERT INTO products(hash_id, user_id, description, dateUpload, price, category, title, product_image) VALUES('hafsh5', '1', "llure5 desc", NOW(), 200, 1, 'llorenc5','llure2.jpg');
   INSERT INTO products(hash_id, user_id, description, dateUpload, price, category, title, product_image) VALUES('hasffh6', '1', "llure6 desc", NOW(), 200, 1, 'llorenc6','llure2.jpg');

 INSERT INTO products(hash_id, user_id, description, dateUpload, price, category, title, product_image) VALUES('hash6', 'QpcvSL', "llure6 desc", NOW(), 200, 1, 'llorenc6','llure2.jpg');

-- UPDATE products SET sold_out = '0' WHERE id LIKE 1;

SELECT * FROM users; 
SELECT * FROM products;

-- INSERT INTO products(hash_id, user_id, description, price, category, title, product_image) VALUES('jgvhgv', 1, 'jgvjghv', 12, 'hgvhgv', 'jhvhgdvhdg', 'jsvhgv')