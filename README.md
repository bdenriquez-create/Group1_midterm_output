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

GET http://localhost/student_enrollment/api/students 

POST http://localhost/student_enrollment/api/students
{
  "first_name": "Test",
  "last_name": "User",
  "email": "test.user@email.com",
  "phone": "09171112222",
  "address": "Manila, PH",
  "date_of_birth": "2000-01-01"
}

PUT http://localhost/student_enrollment/api/students/1
{
  "first_name": "Test",
  "last_name": "Updated",
  "email": "test.updated@email.com",
  "phone": "09171112222",
  "address": "Cebu, PH",
  "date_of_birth": "2000-01-01"
}


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





