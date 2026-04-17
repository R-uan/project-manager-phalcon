CREATE TABLE
    organizations (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,        
        name VARCHAR(50) NOT NULL,
        created_at TIMESTAMPTZ
    );