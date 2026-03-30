<?php
class Database {
    private $host     = 'localhost';
    private $port     = '5432';
    private $db_name  = 'student_enrollment_db';
    private $username = 'postgres';
    private $password = 'bry_2026posgremade'; // ← change this
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
        }
        return $this->conn;
    }
}