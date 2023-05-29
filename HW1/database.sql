Create DATABASE hw1;
USE hw1;

create table users(
	email varchar(128) primary key,
    username varchar(32),
	nome varchar(20),
    cognome varchar(20),
    password varchar(128)
); 

create table apod(
	title varchar(128) primary key,
    username varchar(32) references users(username) on update cascade,
    content json
);

create table commenti(
	username varchar(32),
    commento varchar(512),
    titolo varchar(128) references apod(title) on delete cascade,
    primary key(username, commento, titolo)
);

drop table commenti;
SET SQL_SAFE_UPDATES = 0;


