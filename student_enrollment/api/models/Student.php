<?php
class Student {
    private $conn;
    private $table = 'students';

    public $student_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $created_at;

    public function __construct($db) { $this->conn = $db; }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY student_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE student_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (first_name, last_name, email, phone, address)
                  VALUES (:first_name, :last_name, :email, :phone, :address)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name'  => $data['last_name'],
            ':email'      => $data['email'],
            ':phone'      => $data['phone'] ?? null,
            ':address'    => $data['address'] ?? null,
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET first_name=:first_name, last_name=:last_name,
                      email=:email, phone=:phone, address=:address
                  WHERE student_id=:id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name'  => $data['last_name'],
            ':email'      => $data['email'],
            ':phone'      => $data['phone'] ?? null,
            ':address'    => $data['address'] ?? null,
            ':id'         => $id,
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE student_id = ?");
        return $stmt->execute([$id]);
    }

    public function totalCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}