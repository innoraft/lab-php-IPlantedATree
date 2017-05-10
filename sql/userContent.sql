CREATE TABLE userContent(
	id BIGINT(32) AUTO_INCREMENT,
	fb_id BIGINT(64) UNSIGNED NOT NULL,
	description VARCHAR(200),
	picture_url VARCHAR(100) NOT NULL,
	post_id VARCHAR(100),
	PRIMARY KEY(id)
);

 ALTER TABLE userContent MODIFY description varchar(500);