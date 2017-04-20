CREATE TABLE invitation(
	inviter_id BIGINT(64) UNSIGNED NOT NULL,
	invitee_id BIGINT(64) UNSIGNED NOT NULL,
	invitation_status TINYINT NOT NULL,
	invite_link VARCHAR(100) NOT NULL
);