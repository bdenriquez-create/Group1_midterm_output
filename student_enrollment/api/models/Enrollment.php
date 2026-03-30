<?php
class Enrollment {
    private $conn;
    private $table = 'enrollments';

    public function __construct($db) { $this->conn = $db; }

    public function getAll() {
        $query = "SELECT e.*, s.first_name, s.last_name, c.course_name
                  FROM " . $this->table . " e
                  JOIN students s ON e.student_id = s.student_id
                  JOIN courses c ON e.course_id = c.course_id
                  ORDER BY e.enrollment_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE enrollment_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (student_id, course_id, semester, school_year, status)
                  VALUES (:student_id, :course_id, :semester, :school_year, :status)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':student_id'  => $data['student_id'],
            ':course_id'   => $data['course_id'],
            ':semester'    => $data['semester'] ?? null,
            ':school_year' => $data['school_year'] ?? null,
            ':status'      => $data['status'] ?? 'enrolled',
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET student_id=:student_id, course_id=:course_id,
                      semester=:semester, school_year=:school_year, status=:status
                  WHERE enrollment_id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':student_id'  => $data['student_id'],
            ':course_id'   => $data['course_id'],
            ':semester'    => $data['semester'] ?? null,
            ':school_year' => $data['school_year'] ?? null,
            ':status'      => $data['status'] ?? 'enrolled',
            ':id'          => $id,
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE enrollment_id = ?");
        return $stmt->execute([$id]);
    }

    public function byStudent($studentId) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE student_id = ?");
        $stmt->execute([$studentId]);
        return $stmt;
    }

    public function byCourse($courseId) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE course_id = ?");
        $stmt->execute([$courseId]);
        return $stmt;
    }

    public function perSemester() {
        $query = "SELECT semester, school_year, COUNT(*) as total
                  FROM " . $this->table . "
                  GROUP BY semester, school_year";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}