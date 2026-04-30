CREATE DATABASE edusync;
USE edusync;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(20)
);

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    classroom_number INT NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(20) NOT NULL,
    lastname VARCHAR(20) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(256) NOT NULL,
    role_id INT,
    class_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (class_id) REFERENCES classes(id)
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    total_hours INT NOT NULL,
    professor_id INT,
    FOREIGN KEY (professor_id) REFERENCES users(id)
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_of_birth DATE NOT NULL,
    student_number INT NOT NULL,
    class_id INT,
    user_id INT UNIQUE,
    FOREIGN KEY (class_id) REFERENCES classes(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enrolled_at DATE NOT NULL,
    status ENUM('Actif','Terminé') NOT NULL,
    student_id INT,
    course_id INT,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (course_id) REFERENCES courses(id),
    UNIQUE(student_id, course_id)
);





