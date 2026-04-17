CREATE TABLE
    assigned_project_members (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,        
        project_id INT NOT NULL,
        membership_id INT NOT NULL,
    )