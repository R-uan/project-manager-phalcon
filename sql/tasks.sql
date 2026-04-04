CREATE TABLE
    tasks (
        id SERIAL PRIMARY KEY,
        title VARCHAR(50) NOT NULL,
        description VARCHAR(500),
        created_at DATETIME,
        startline DATETIME,
        deadline DATETIME,
        project_id INT NOT NULL,
    );