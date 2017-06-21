CREATE TABLE userContent(
	id BIGINT(32) AUTO_INCREMENT,
	fb_id BIGINT(64) UNSIGNED NOT NULL,
	description varchar(500),
	picture_url VARCHAR(100) NOT NULL,
	post_id VARCHAR(100),
	timestamp INT(12) NOT NULL,
	PRIMARY KEY(id)
);
