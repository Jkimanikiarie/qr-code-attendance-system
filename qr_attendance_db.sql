-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('lecturer', 'student') NOT NULL
);

-- Create the tbl_student table
CREATE TABLE IF NOT EXISTS tbl_student (
    tbl_student_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(255) NOT NULL,
    course_section VARCHAR(255) NOT NULL,
    admission_number VARCHAR(255) NOT NULL UNIQUE,
    unit_name VARCHAR(255) NOT NULL,
    academic_year VARCHAR(255) NOT NULL,
    generated_code VARCHAR(255) NOT NULL
);

-- Create the tbl_attendance table
CREATE TABLE IF NOT EXISTS tbl_attendance (
    tbl_attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    tbl_student_id INT NOT NULL,
    time_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tbl_student_id) REFERENCES tbl_student(tbl_student_id)
);