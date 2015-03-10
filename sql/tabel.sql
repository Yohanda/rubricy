DROP table tb_user;
CREATE TABLE tb_user
(
id_user BIGINT PRIMARY KEY ,
username VARCHAR(100) NOT NULL UNIQUE,
password_user VARCHAR(100) NOT NULL ,
profile_picture VARCHAR(100) NOT NULL DEFAULT 'image/user/default_pp.jpg' ,
first_name VARCHAR(100) NOT NULL,
last_name VARCHAR(100) NOT NULL,
gender bit NOT NULL,
email VARCHAR(100) NOT NULL,
hak_akses bit DEFAULT 0
);