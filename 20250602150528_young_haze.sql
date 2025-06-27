-- Student Information System Database

CREATE DATABASE IF NOT EXISTS student_information_system;
USE student_information_system;

-- Admin table (intentionally using plaintext passwords as specified)
CREATE TABLE IF NOT EXISTS admin (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (username: admin, password: admin123)
INSERT INTO admin (username, password, full_name, email) 
VALUES ('admin', 'admin123', 'System Administrator', 'admin@example.com');

-- Students table
CREATE TABLE IF NOT EXISTS students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    registration_number VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    date_of_birth DATE NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(20),
    parent_name VARCHAR(100),
    parent_phone VARCHAR(20),
    enrollment_date DATE NOT NULL,
    status ENUM('Active', 'Inactive', 'Graduated', 'Suspended') DEFAULT 'Active',
    profile_image VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Courses table
CREATE TABLE IF NOT EXISTS courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(20) UNIQUE NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    description TEXT,
    credits INT NOT NULL,
    department VARCHAR(100),
    semester VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Enrollments table (connects students with courses)
CREATE TABLE IF NOT EXISTS enrollments (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE NOT NULL,
    status ENUM('Active', 'Completed', 'Withdrawn', 'Failed') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    UNIQUE KEY (student_id, course_id) -- Prevent duplicate enrollments
);

-- Grades table
CREATE TABLE IF NOT EXISTS grades (
    grade_id INT PRIMARY KEY AUTO_INCREMENT,
    enrollment_id INT NOT NULL,
    assignment_name VARCHAR(100) NOT NULL,
    marks_obtained DECIMAL(5,2) NOT NULL,
    max_marks DECIMAL(5,2) NOT NULL,
    grade_letter VARCHAR(5),
    comments TEXT,
    graded_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(enrollment_id) ON DELETE CASCADE
);

-- Attendance table
CREATE TABLE IF NOT EXISTS attendance (
    attendance_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    status ENUM('Present', 'Absent', 'Late', 'Excused') NOT NULL,
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    UNIQUE KEY (student_id, course_id, attendance_date) -- Prevent duplicate attendance records
);

-- Sample data for students
INSERT INTO students (registration_number, first_name, last_name, gender, date_of_birth, email, phone, address, city, state, zip_code, parent_name, parent_phone, enrollment_date) VALUES
('2023-CS-001', 'John', 'Doe', 'Male', '2000-05-15', 'john.doe@example.com', '555-123-4567', '123 College St', 'Springfield', 'IL', '62701', 'Jane Doe', '555-987-6543', '2023-01-15'),
('2023-CS-002', 'Sarah', 'Smith', 'Female', '2001-08-22', 'sarah.smith@example.com', '555-234-5678', '456 University Ave', 'Springfield', 'IL', '62702', 'Robert Smith', '555-876-5432', '2023-01-15'),
('2023-CS-003', 'Michael', 'Johnson', 'Male', '2000-11-30', 'michael.j@example.com', '555-345-6789', '789 Campus Rd', 'Springfield', 'IL', '62703', 'Maria Johnson', '555-765-4321', '2023-01-16'),
('2023-CS-004', 'Emily', 'Williams', 'Female', '2001-04-12', 'emily.w@example.com', '555-456-7890', '101 Academy Blvd', 'Springfield', 'IL', '62704', 'Thomas Williams', '555-654-3210', '2023-01-16'),
('2023-CS-005', 'Daniel', 'Brown', 'Male', '2000-07-25', 'daniel.b@example.com', '555-567-8901', '202 Learning Ln', 'Springfield', 'IL', '62705', 'Sophia Brown', '555-543-2109', '2023-01-17');

-- Sample data for courses
INSERT INTO courses (course_code, course_name, description, credits, department, semester) VALUES
('CS101', 'Introduction to Programming', 'Basic concepts of programming using Python', 3, 'Computer Science', 'Fall 2023'),
('CS201', 'Data Structures', 'Study of data structures and algorithms', 4, 'Computer Science', 'Spring 2024'),
('MATH101', 'Calculus I', 'Introduction to differential and integral calculus', 4, 'Mathematics', 'Fall 2023'),
('ENG101', 'English Composition', 'Fundamentals of college-level writing', 3, 'English', 'Fall 2023'),
('PHYS101', 'Physics I', 'Introduction to mechanics and thermodynamics', 4, 'Physics', 'Spring 2024');

-- Sample data for enrollments
INSERT INTO enrollments (student_id, course_id, enrollment_date, status) VALUES
(1, 1, '2023-01-20', 'Active'),
(1, 3, '2023-01-20', 'Active'),
(1, 4, '2023-01-20', 'Active'),
(2, 1, '2023-01-21', 'Active'),
(2, 3, '2023-01-21', 'Active'),
(2, 5, '2023-01-21', 'Active'),
(3, 2, '2023-01-22', 'Active'),
(3, 3, '2023-01-22', 'Active'),
(3, 4, '2023-01-22', 'Active'),
(4, 1, '2023-01-23', 'Active'),
(4, 2, '2023-01-23', 'Active'),
(4, 5, '2023-01-23', 'Active'),
(5, 2, '2023-01-24', 'Active'),
(5, 4, '2023-01-24', 'Active'),
(5, 5, '2023-01-24', 'Active');

-- Sample data for grades
INSERT INTO grades (enrollment_id, assignment_name, marks_obtained, max_marks, grade_letter, comments, graded_date) VALUES
(1, 'Quiz 1', 18, 20, 'A', 'Excellent work', '2023-02-15'),
(1, 'Assignment 1', 45, 50, 'A', 'Great effort', '2023-02-28'),
(2, 'Midterm Exam', 85, 100, 'B', 'Good understanding of concepts', '2023-03-15'),
(3, 'Essay 1', 88, 100, 'B+', 'Well-written with minor grammatical errors', '2023-02-20'),
(4, 'Quiz 1', 17, 20, 'A-', 'Good work', '2023-02-15'),
(5, 'Midterm Exam', 92, 100, 'A', 'Excellent understanding of calculus concepts', '2023-03-15'),
(8, 'Midterm Exam', 78, 100, 'C+', 'Needs improvement in integration techniques', '2023-03-15');

-- Sample data for attendance
INSERT INTO attendance (student_id, course_id, attendance_date, status, remarks) VALUES
(1, 1, '2023-01-22', 'Present', NULL),
(1, 1, '2023-01-25', 'Present', NULL),
(1, 1, '2023-01-29', 'Absent', 'Sick leave'),
(1, 3, '2023-01-23', 'Present', NULL),
(1, 3, '2023-01-26', 'Present', NULL),
(1, 3, '2023-01-30', 'Present', NULL),
(2, 1, '2023-01-22', 'Present', NULL),
(2, 1, '2023-01-25', 'Late', 'Arrived 10 minutes late'),
(2, 1, '2023-01-29', 'Present', NULL),
(3, 2, '2023-01-24', 'Present', NULL),
(3, 2, '2023-01-27', 'Present', NULL),
(3, 2, '2023-01-31', 'Excused', 'Family emergency');