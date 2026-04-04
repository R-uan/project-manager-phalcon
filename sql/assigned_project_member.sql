CREATE TABLE
    assigned_project_members (
        id SERIAL PRIMARY KEY,
        project_id INT NOT NULL,
        membership_id INT NOT NULL,
    )