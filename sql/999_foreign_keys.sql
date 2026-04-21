ALTER TABLE projects
    ADD CONSTRAINT fk_projects_organizations
    FOREIGN KEY (organization_id) REFERENCES organizations(id)
    ON DELETE CASCADE;

ALTER TABLE tasks
    ADD CONSTRAINT fk_tasks_projects
    FOREIGN KEY (project_id) REFERENCES projects(id)
    ON DELETE CASCADE;

ALTER TABLE organization_contacts
    ADD CONSTRAINT fk_organization_contact_organizations
    FOREIGN KEY (organization_id) REFERENCES organizations(id)
    ON DELETE CASCADE;

ALTER TABLE memberships
    ADD CONSTRAINT fk_memberships_users
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE,
    
    ADD CONSTRAINT fk_memberships_organizations
    FOREIGN KEY (organization_id) REFERENCES organizations(id)
    ON DELETE CASCADE;

ALTER TABLE assigned_task_members
    ADD CONSTRAINT fk_assigned_task_members_tasks
    FOREIGN KEY (task_id) REFERENCES tasks(id)
    ON DELETE CASCADE,

    ADD CONSTRAINT fk_assigned_task_members_assigned_member
    FOREIGN KEY (assigned_member_id) REFERENCES assigned_project_members(id)
    ON DELETE CASCADE;

ALTER TABLE assigned_project_members 
    ADD CONSTRAINT fk_assigned_project_members_projects
    FOREIGN KEY (project_id) REFERENCES projects(id)
    ON DELETE CASCADE,
    
    ADD CONSTRAINT fk_assigned_project_members_memberships
    FOREIGN KEY (membership_id) REFERENCES memberships(id)
    ON DELETE CASCADE;

ALTER TABLE organization_invites
    ADD CONSTRAINT pk_organization_user_invites
        PRIMARY KEY (invitee_user_id, organization_id),

    ADD CONSTRAINT fk_invite_invitee
        FOREIGN KEY (invitee_user_id) REFERENCES public.users(id),

    ADD CONSTRAINT fk_invite_inviter
        FOREIGN KEY (inviter_user_id) REFERENCES public.users(id),

    ADD CONSTRAINT fk_invite_organization
        FOREIGN KEY (organization_id) REFERENCES public.organizations(id);