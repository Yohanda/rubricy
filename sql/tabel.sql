
--CREATE TABLE tb_user
--(
--id_user BIGINT IDENTITY(1,1) PRIMARY KEY ,
--username VARCHAR(100) NOT NULL UNIQUE,
--password_user VARCHAR(100) NOT NULL ,
--profile_picture VARCHAR(100) NOT NULL DEFAULT 'image/user/default_pp.jpg' ,
--first_name VARCHAR(100) NOT NULL,
--last_name VARCHAR(100) NOT NULL,
--gender bit NOT NULL,
--email VARCHAR(100) NOT NULL,
--hak_akses bit DEFAULT 0
--);

--CREATE TABLE tb_kategori
--(
--id_kategori BIGINT IDENTITY(1,1) PRIMARY KEY ,
--nama_kategori VARCHAR(100) NOT NULL UNIQUE
--)
--CREATE TABLE tb_rubrik
--(
--id_rubrik BIGINT IDENTITY(1,1) PRIMARY KEY ,
--judul VARCHAR(100) NOT NULL UNIQUE,
--status_berbagi bit NOT NULL ,
--evaluation_method smallint NOT NULL DEFAULT 0 ,
--status_evaluasi smallint NOT NULL DEFAULT 0,
--enrollment_key VARCHAR(100) ,
--deskripsi TEXT,
--id_kategori BIGINT NOT NULL REFERENCES tb_kategori(id_kategori),
--tanggal_dibuat DATETIME DEFAULT CURRENT_TIMESTAMP 
--)

--CREATE TABLE tb_kriteria
--(
--id_kriteria BIGINT IDENTITY(1,1) PRIMARY KEY,
--id_rubrik BIGINT NOT NULL REFERENCES tb_rubrik(id_rubrik) ,
--nama_kriteria VARCHAR(100) NOT NULL,
--persentase_kriteria INT NOT NULL 
--)






--CREATE TABLE tb_bobot
--(
--id_bobot BIGINT IDENTITY(1,1) PRIMARY KEY,
--id_rubrik BIGINT NOT NULL REFERENCES tb_rubrik(id_rubrik) ,
--nama_bobot VARCHAR(100) NOT NULL,
--nilai_bobot INT NOT NULL 
--)



--CREATE TABLE tb_deskripsi_bobot
--(
--id_deskripsi_bobot BIGINT IDENTITY(1,1) PRIMARY KEY,
--id_bobot BIGINT NOT NULL REFERENCES tb_bobot(id_bobot) ,
--id_kriteria BIGINT NOT NULL REFERENCES tb_kriteria(id_kriteria) ,
--id_rubrik BIGINT NOT NULL REFERENCES tb_rubrik(id_rubrik) ,
--deskripsi_bobot TEXT NOT NULL
--)



--CREATE TABLE tb_komentar
--(
--id_komentar BIGINT IDENTITY(1,1) PRIMARY KEY,
--id_rubrik BIGINT NOT NULL REFERENCES tb_rubrik(id_rubrik) ,
--id_user BIGINT NOT NULL REFERENCES tb_user(id_user) ,
--isi_komentar TEXT NOT NULL,
--waktu_komentar DATETIME DEFAULT CURRENT_TIMESTAMP 
--)


CREATE TABLE tb_join
(

id_rubrik BIGINT NOT NULL REFERENCES tb_rubrik(id_rubrik) ,
id_user BIGINT NOT NULL REFERENCES tb_user(id_user) ,
evaluated smallint NOT NULL DEFAULT 0 ,
total_nilai BIGINT NOT NULL,
waktu_join DATETIME DEFAULT CURRENT_TIMESTAMP 
)

CREATE TABLE tb_peer
(

id_rubrik BIGINT NOT NULL REFERENCES tb_rubrik(id_rubrik) ,
id_user BIGINT NOT NULL REFERENCES tb_user(id_user) ,
id_user_evaluator BIGINT NOT NULL REFERENCES tb_user(id_user)
)

CREATE TABLE tb_nilai
(

id_rubrik BIGINT NOT NULL REFERENCES tb_rubrik(id_rubrik) ,
id_user BIGINT NOT NULL REFERENCES tb_user(id_user),
id_bobot BIGINT NOT NULL REFERENCES tb_bobot(id_bobot) ,
id_kriteria BIGINT NOT NULL REFERENCES tb_kriteria(id_kriteria) 
)




