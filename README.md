Group1_midterm_output
# Student Enrollment System API (PostgreSQL)
This project is a RESTful API built using PHP (OOP) and PostgreSQL. It manages students, courses, and enrollments, supporting CRUD operations, relationship queries, and analytics reporting.

# Database (PostgreSQL)
🧑 Students Table
student_id (PRIMARY KEY)
first_name
last_name
email
phone
address
created_at

📘 Courses Table
course_id (PRIMARY KEY)
course_code
course_name
description
units

📝 Enrollments Table
enrollment_id (PRIMARY KEY)
student_id (FOREIGN KEY → students.student_id)
course_id (FOREIGN KEY → courses.course_id)
semester
school_year
status

Method	Endpoint	Description
GET	   /enrollments	     Get all enrollments (with JOIN data)
GET	/enrollments/{id}	Get single enrollment
POST	/enrollments	Create enrollment
PUT	/enrollments/{id}	Update enrollment
DELETE	/enrollments/{id}	Delete enrollment



