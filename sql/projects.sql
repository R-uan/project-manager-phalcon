CREATE TABLE
    projects (
        id SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description VARCHAR(500),
        deadline DATETIME,
        startline DATETIME,
        created_at DATETIME,
        updated_at DATETIME,
        organization_id INT NOT NULL,
    );