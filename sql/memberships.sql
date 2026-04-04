CREATE TABLE
    memberships (
        id SERIAL PRIMARY KEY,
        role VARCHAR(20) NOT NULL,
        user_id INT NOT NULL,
        organization_id INT NOT NULL,
    );