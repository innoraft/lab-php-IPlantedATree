CREATE TABLE invitation(
	inviter_id BIGINT(64) UNSIGNED NOT NULL,
	invitee_id BIGINT(64) UNSIGNED NOT NULL,
	invitation_status TINYINT NOT NULL,
	invite_link VARCHAR(100) NOT NULL
);

ALTER TABLE invitation ALTER COLUMN invitation_status SET DEFAULT '0';
ALTER TABLE invitation ADD FOREIGN KEY(inviter_id) REFERENCES user(fb_id);
