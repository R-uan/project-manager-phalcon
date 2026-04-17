CREATE TABLE
    memberships (
        id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,        
        role VARCHAR(20) NOT NULL,
        user_id INT NOT NULL,
        organization_id INT NOT NULL,
    );