<?php
class Course {
    private $conn;
    private $table = 'courses';

    public $course_id;
    public $course_code;
    public $course_name;
    public $description;
    public $units;

    public function __construct($db) { $this->conn = $db; }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY course_id DESC");
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE course_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (course_code, course_name, description, units)
                  VALUES (:course_code, :course_name, :description, :units)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':course_code' => $data['course_code'],
            ':course_name' => $data['course_name'],
            ':description' => $data['description'] ?? null,
            ':units'       => $data['units'] ?? null,
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET course_code=:course_code, course_name=:course_name,
                      description=:description, units=:units
                  WHERE course_id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':course_code' => $data['course_code'],
            ':course_name' => $data['course_name'],
            ':description' => $data['description'] ?? null,
            ':units'       => $data['units'] ?? null,
            ':id'          => $id,
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE course_id = ?");
        return $stmt->execute([$id]);
    }

    public function studentsPerCourse() {
        $query = "SELECT c.course_id, c.course_name, COUNT(e.student_id) as total_students
                  FROM " . $this->table . " c
                  LEFT JOIN enrollments e ON c.course_id = e.course_id
                  GROUP BY c.course_id, c.course_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}