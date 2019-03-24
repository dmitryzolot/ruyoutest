create database ruyoutest
default character set utf8
default collate utf8_general_ci;
use ruyoutest;

create table note (
id int auto_increment primary key,
name char(50) not null,
message char(240),
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
description char(50) not null,
picture char(200)
);