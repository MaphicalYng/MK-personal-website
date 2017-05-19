-- Create database newapp.

CREATE DATABASE newapp;
USE newapp;

-- The structure of table user.

CREATE TABLE user (
	user text character set utf8 not null,
	password varchar(255),
	email varchar(255)
);

-- The structure of table content.

CREATE TABLE content (
	user text character set utf8 not null,
	item text character set utf8 not null,
	content text character set utf8 not null
);
