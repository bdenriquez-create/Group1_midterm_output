Group1_midterm_output
# Student Enrollment System API (PostgreSQL)
This project is a RESTful API built using PHP (OOP) and PostgreSQL. It manages students, courses, and enrollments, supporting CRUD operations, relationship queries, and analytics reporting.

# URL
http://localhost/student_enrollment/api/

# Database (PostgreSQL)
Students Table
student_id (PRIMARY KEY)
first_name
last_name
email
phone
address
created_at

Courses Table
course_id (PRIMARY KEY)
course_code
course_name
description
units

Enrollments Table
enrollment_id (PRIMARY KEY)
student_id (FOREIGN KEY → students.student_id)
course_id (FOREIGN KEY → courses.course_id)
semester
school_year
status

# API Endpoints
Students
| Method | Endpoint         | Description        |
| ------ | ---------------- | ------------------ |
| GET    | `/students`      | Get all students   |
| GET    | `/students/{id}` | Get single student |
| POST   | `/students`      | Create student     |
| PUT    | `/students/{id}` | Update student     |
| DELETE | `/students/{id}` | Delete student     |

Analytics
GET http://localhost/student_enrollment/api/students/analytics/total

# Courses 
| Method | Endpoint        | Description       |
| ------ | --------------- | ----------------- |
| GET    | `/courses`      | Get all courses   |
| GET    | `/courses/{id}` | Get single course |
| POST   | `/courses`      | Create course     |
| PUT    | `/courses/{id}` | Update course     |
| DELETE | `/courses/{id}` | Delete course     |

Analytics
GET http://localhost/student_enrollment/api/courses/analytics/students-per-course

# Enrollments
| Method | Endpoint            | Description                          |
| ------ | ------------------- | ------------------------------------ |
| GET    | `/enrollments`      | Get all enrollments (with JOIN data) |
| GET    | `/enrollments/{id}` | Get single enrollment                |
| POST   | `/enrollments`      | Create enrollment                    |
| PUT    | `/enrollments/{id}` | Update enrollment                    |
| DELETE | `/enrollments/{id}` | Delete enrollment                    |

Analytics
GET http://localhost/student_enrollment/api/enrollments/analytics/per-semester

# Member Roles & Responsibilities
Member 1 – Database Designer (Enriquez, Bryan D.)
Designed PostgreSQL database schema
Created tables with primary and foreign keys
Prepared .sql file


Member 2 – Model Developer (PHP OOP) (Pakingan, Mark Aljay)
Developed models:
Student.php
Course.php
Enrollment.php
Implemented database queries using PDO (PostgreSQL)


Member 3 – CRUD API Developer (Cruz, Ramon Jr. & Pitargue, Aizelle Mynina)
Implemented CRUD endpoints in controllers
Connected models to API routes
Tested create, read, update, delete operations


Member 4 – Relationship API Developer (Bagagnan, Jose Manuel)
Implemented:
byStudent()
byCourse()
Created JOIN queries for relational data


Member 5 – Data Analytics Developer (Tapia, Emmanuel Keith)
Implemented:
totalCount()
studentsPerCourse()
perSemester()
Used PostgreSQL aggregation (COUNT, GROUP BY)


Member 6 – Documentation & Testing (Centeno, Angelika Mae)
Wrote README.md
Tested endpoints using Postman
Verified API responses





