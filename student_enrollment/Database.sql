-- ============================================================
-- Student Enrollment System — PostgreSQL Database Schema
-- ============================================================

DROP TABLE IF EXISTS enrollments CASCADE;
DROP TABLE IF EXISTS courses     CASCADE;
DROP TABLE IF EXISTS students    CASCADE;

-- ============================================================
-- STUDENTS
-- ============================================================
CREATE TABLE students (
    student_id    SERIAL PRIMARY KEY,
    first_name    VARCHAR(100) NOT NULL,
    last_name     VARCHAR(100) NOT NULL,
    email         VARCHAR(150) UNIQUE NOT NULL,
    phone         VARCHAR(20),
    address       TEXT,
    date_of_birth DATE,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- COURSES
-- ============================================================
CREATE TABLE courses (
    course_id    SERIAL PRIMARY KEY,
    course_code  VARCHAR(20)  UNIQUE NOT NULL,
    course_name  VARCHAR(200) NOT NULL,
    description  TEXT,
    units        INT  NOT NULL DEFAULT 3,
    instructor   VARCHAR(150),
    max_capacity INT  DEFAULT 40,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- ENROLLMENTS
-- ============================================================
CREATE TABLE enrollments (
    enrollment_id SERIAL PRIMARY KEY,
    student_id    INT NOT NULL,
    course_id     INT NOT NULL,
    semester      VARCHAR(20) NOT NULL,   -- '1st' | '2nd' | 'Summer'
    school_year   VARCHAR(10) NOT NULL,   -- '2024-2025'
    grade         DECIMAL(4,2),
    status        VARCHAR(20) NOT NULL DEFAULT 'enrolled',
                                          -- enrolled | dropped | completed
    enrolled_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_student    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    CONSTRAINT fk_course     FOREIGN KEY (course_id)  REFERENCES courses(course_id)  ON DELETE CASCADE,
    CONSTRAINT uq_enrollment UNIQUE (student_id, course_id, semester, school_year)
);

CREATE INDEX idx_enroll_student  ON enrollments(student_id);
CREATE INDEX idx_enroll_course   ON enrollments(course_id);
CREATE INDEX idx_enroll_semester ON enrollments(semester, school_year);

-- ============================================================
-- SAMPLE DATA
-- ============================================================
INSERT INTO students (first_name, last_name, email, phone, address, date_of_birth) VALUES
('Juan',   'Dela Cruz', 'juan.delacruz@email.com', '09171234567', 'Manila, PH',      '2002-03-15'),
('Maria',  'Santos',    'maria.santos@email.com',  '09182345678', 'Quezon City, PH', '2001-07-22'),
('Pedro',  'Reyes',     'pedro.reyes@email.com',   '09193456789', 'Makati, PH',      '2003-01-10'),
('Ana',    'Garcia',    'ana.garcia@email.com',    '09204567890', 'Pasig, PH',       '2002-11-05'),
('Carlos', 'Lopez',     'carlos.lopez@email.com',  '09215678901', 'Taguig, PH',      '2001-09-18');

INSERT INTO courses (course_code, course_name, description, units, instructor, max_capacity) VALUES
('CS101',   'Introduction to Programming',  'Basic programming concepts using Python', 3, 'Prof. Reyes',  35),
('CS102',   'Data Structures',              'Arrays, linked lists, trees, graphs',     3, 'Prof. Santos', 30),
('CS201',   'Database Management Systems',  'SQL, NoSQL, and database design',         3, 'Prof. Cruz',   40),
('CS202',   'Web Development',              'HTML, CSS, JavaScript, and PHP',          3, 'Prof. Garcia', 35),
('MATH101', 'Calculus I',                   'Limits, derivatives, and integrals',      5, 'Prof. Lim',    50);

INSERT INTO enrollments (student_id, course_id, semester, school_year, grade, status) VALUES
(1, 1, '1st', '2024-2025', 1.25, 'completed'),
(1, 2, '1st', '2024-2025', 1.50, 'completed'),
(1, 3, '2nd', '2024-2025', NULL, 'enrolled'),
(2, 1, '1st', '2024-2025', 1.00, 'completed'),
(2, 4, '2nd', '2024-2025', NULL, 'enrolled'),
(3, 5, '1st', '2024-2025', 2.00, 'completed'),
(3, 3, '2nd', '2024-2025', NULL, 'enrolled'),
(4, 2, '1st', '2024-2025', 1.75, 'completed'),
(4, 4, '2nd', '2024-2025', NULL, 'enrolled'),
(5, 5, '1st', '2024-2025', 2.25, 'completed');