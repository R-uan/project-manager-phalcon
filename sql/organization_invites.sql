CREATE TABLE organization_user_invites (
    invitee_user_id INTEGER NOT NULL,
    inviter_user_id INTEGER NOT NULL,
    organization_id INTEGER NOT NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT NOW(),
    active          BOOLEAN NOT NULL DEFAULT TRUE,

    PRIMARY KEY (invitee_user_id, organization_id)
);