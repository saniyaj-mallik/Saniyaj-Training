CREATE DATABASE user_auth;

USE user_auth;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,           
    name VARCHAR(100) NOT NULL,                  
    user_name VARCHAR(100) NOT NULL UNIQUE,                 
    email VARCHAR(150) NOT NULL UNIQUE,          
    mobile_number VARCHAR(15) NOT NULL UNIQUE,   
    password VARCHAR(255) NOT NULL, 
    gender ENUM('male', 'female', 'others') NOT NULL,            
    code VARCHAR(50),                           
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);
