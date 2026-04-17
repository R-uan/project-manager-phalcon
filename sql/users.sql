CREATE TABLE
    users (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,        
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50),
        created_at TIMESTAMPTZ,
        location VARCHAR(20),
        last_login TIMESTAMPTZ,
        website VARCHAR(50)
    );