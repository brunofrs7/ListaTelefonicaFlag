DROP TABLE IF EXISTS contact;
DROP TABLE IF EXISTS user;

CREATE TABLE user(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(20),
    email_valid INT DEFAULT 0,
    email_validated_at DATETIME,
    email_link VARCHAR(100),
    email_recover VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME
);

CREATE TABLE contact(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255),
    photo VARCHAR(20),
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME,
    user_id INT,

    FOREIGN KEY (user_id) REFERENCES user(id)
);