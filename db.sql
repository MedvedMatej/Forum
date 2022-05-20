drop database if exists forum;
create database forum;
use forum;


CREATE TABLE `User` (
	`UID` bigint NOT NULL AUTO_INCREMENT,
	`username` varchar(50) NOT NULL,
	`password` varchar(100) NOT NULL,
	`date` DATE NOT NULL,
	PRIMARY KEY (`UID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Theme` (
	`tid` bigint NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`description` TEXT NOT NULL,
	PRIMARY KEY (`tid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Post` (
	`pid` bigint NOT NULL AUTO_INCREMENT,
	`Title` varchar(100) NOT NULL,
	`Text` TEXT NOT NULL,
	`Image` varchar(250),
	`date` DATE NOT NULL,
	`uid` bigint NOT NULL,
	PRIMARY KEY (`pid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Comment` (
	`cid` bigint NOT NULL AUTO_INCREMENT,
	`text` TEXT NOT NULL,
	`date` DATE NOT NULL,
	`pid` bigint NOT NULL,
	`uid` bigint NOT NULL,
	`fid` bigint,
	PRIMARY KEY (`cid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Post_themes` (
	`pid` bigint NOT NULL,
	`tid` bigint NOT NULL,
	PRIMARY KEY (`pid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Post` ADD CONSTRAINT `Post_fk0` FOREIGN KEY (`uid`) REFERENCES `User`(`UID`);

ALTER TABLE `Comment` ADD CONSTRAINT `Comment_fk0` FOREIGN KEY (`pid`) REFERENCES `Post`(`pid`);

ALTER TABLE `Comment` ADD CONSTRAINT `Comment_fk1` FOREIGN KEY (`uid`) REFERENCES `User`(`UID`);

ALTER TABLE `Comment` ADD CONSTRAINT `Comment_fk2` FOREIGN KEY (`fid`) REFERENCES `Comment`(`cid`);

ALTER TABLE `Post_themes` ADD CONSTRAINT `Post_themes_fk0` FOREIGN KEY (`pid`) REFERENCES `Post`(`pid`);

ALTER TABLE `Post_themes` ADD CONSTRAINT `Post_themes_fk1` FOREIGN KEY (`tid`) REFERENCES `Theme`(`tid`);






