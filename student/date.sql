CREATE DATABASE edusync;
USE edusync;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(20)
);

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    classroom_number INT 
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


-- data :

INSERT INTO roles (label) VALUES
('admin'),
('teacher'),
('student');


INSERT INTO classes(name,classroom_number) VALUES
('DEV101', 1),
('DEV102', 2),
('DEV103', 3);


INSERT INTO users (firstname, lastname, email, password, role_id) VALUES
('Ali', 'Admin', 'admin@edusync.com', '123', 1),
('Sara', 'Teacher', 'teacher@edusync.com', '123', 2),
('Amine', 'Student', 'amine@edusync.com', '123', 3),
('Yassine', 'Student', 'yassine@edusync.com', '123', 3),
('Omar', 'Student', 'omar@edusync.com', '123', 3);


INSERT INTO students (date_of_birth, student_number, class_id, user_id) VALUES
('2001-05-10', 1001, 1, 3),
('2002-03-22', 1002, 1, 4),
('2000-12-01', 1003, 2, 5);



INSERT INTO courses (title, description, total_hours, professor_id) VALUES
('PHP', 'Backend development with PHP', 40, 2),
('SQL', 'Database design and queries', 30, 2),
('HTML/CSS', 'Frontend basics', 25, 2);



INSERT INTO enrollments (enrolled_at, status, student_id, course_id) VALUES
(CURDATE(), 'Actif', 1, 1),
(CURDATE(), 'Actif', 1, 2),
(CURDATE(), 'Actif', 2, 1),
(CURDATE(), 'Terminé', 3, 3);
