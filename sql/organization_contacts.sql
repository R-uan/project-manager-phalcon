CREATE TABLE
    organization_contacts (
        id SERIAL PRIMARY KEY,
        website VARCHAR(100),
        email VARCHAR(100),
        number VARCHAR(20),
        organization_id INT NOT NULL,
    );