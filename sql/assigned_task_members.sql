CREATE TABLE
    assigned_task_members (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,        
        task_id INT NOT NULL,
        assigned_member_id INT NOT NULL,
    );