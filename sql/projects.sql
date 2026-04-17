CREATE TABLE
    projects (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,        
        name VARCHAR(50) NOT NULL,
        description VARCHAR(500),
        deadline TIMESTAMPTZ,
        startline TIMESTAMPTZ,
        created_at TIMESTAMPTZ,
        updated_at TIMESTAMPTZ,
        organization_id INT NOT NULL,
    );