CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    salt VARCHAR(255) NOT NULL
);

CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    salt VARCHAR(255) NOT NULL
);

-- Insert default admin user
INSERT INTO admin_users (username, password, salt) VALUES ('admin', '${ADMIN_PASSWORD_HASH}', '${ADMIN_SALT}');

-- Create additional table and insert data
-- CREATE TABLE other_table (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(50) NOT NULL
-- );

-- INSERT INTO other_table (name) VALUES ('Some Data');
