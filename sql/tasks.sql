CREATE TABLE
    tasks (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,        
        title VARCHAR(50) NOT NULL,
        description VARCHAR(500),
        created_at TIMESTAMPTZ,
        startline TIMESTAMPTZ,
        deadline TIMESTAMPTZ,
        project_id INT NOT NULL,
    );