CREATE TABLE
    organizations (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,       
        handle VARCHAR(50) NOT NULL UNIQUE,
        display_name VARCHAR(255) NOT NULL,
        is_public BOOLEAN NOT NULL,
        location VARCHAR(20),
        created_at TIMESTAMPTZ
    );