CREATE TABLE user(
	fb_name VARCHAR(50) NOT NULL,
	fb_id BIGINT(64) UNSIGNED NOT NULL,
	fb_profile_pic_path VARCHAR(100) NOT NULL
);

ALTER TABLE user ADD PRIMARY KEY(fb_id);
ALTER TABLE user ADD UNIQUE (fb_id);







INSERT IGNORE INTO user VALUES ('vivek',123,'xyzz.png'); OK.
INSERT IGNORE INTO user VALUES ('vivek',123,'xyzz.png'); OK. But not inserted.