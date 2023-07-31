create database cinemasense;
use cinemasense;
create table admin (id int not null auto_increment,email varchar(255),username varchar(255),password varchar(255),full_name varchar(255),profile varchar(255),role varchar(255),last_login date,primary key(id));
insert into admin (email,username,password
,full_name,profile,role,last_login) values ('mike@cinemasense.com','mike','81dc9bdb52d04dc20036dbd8313ed055','Mike','1eedbe4db2007e7536d05b4799f6a991.png','administrator',curdate());
create table posts (id int not null auto_increment,image varchar(255),category varchar(255),title varchar(1000),rating varchar(255),content varchar(30000),album varchar(1000),username varchar(255),author varchar(255),profile varchar(255),posted_time int,primary key(id));
