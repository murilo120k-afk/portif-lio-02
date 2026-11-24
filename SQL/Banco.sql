create database if not exists KonLivro ;
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
use KonLivro

create table if not exists livros(
id int primary key auto_increment,
autor varchar(100) not null,
titulo varchar(100) not null,
categoria varchar(100) not null,
ano_publicacao int ,
adiçao date default current_date,
quantidade int default 1
);  