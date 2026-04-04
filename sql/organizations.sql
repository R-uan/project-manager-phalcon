CREATE TABLE
    organizations (
        id SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        created_at DATETIME
    );