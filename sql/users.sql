CREATE TABLE
    users (
        id SERIAL PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50),
        created_at DATETIME,
        location VARCHAR(20),
        last_login DATETIME,
        website VARCHAR(50)
    );