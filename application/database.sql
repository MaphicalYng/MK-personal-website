--
-- The SQL file built for website/app.
-- By MaphicalYng.
--

-- Create database newapp.

CREATE DATABASE newapp;
USE newapp;

-- The structure of table user.

CREATE TABLE user (
	user VARCHAR(255),
	password VARCHAR(255),
	email VARCHAR(255)
);

-- The structure of table content.

CREATE TABLE content (
	user VARCHAR(255),
	item TEXT CHARACTER SET utf8 NOT NULL,
	content TEXT CHARACTER SET utf8 NOT NULL,
	create_time DATETIME NOT NULL DEFAULT NOW()
);

-- Create index on table user.

CREATE INDEX user_index ON newapp.user(user);
