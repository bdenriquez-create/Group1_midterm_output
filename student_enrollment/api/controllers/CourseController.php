<?php
require_once __DIR__ . '/../models/Course.php';

class CourseController {
    private $model;
    public function __construct($db) { $this->model = new Course($db); }

    public function index() {
        $stmt = $this->model->getAll();
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    }
    public function show($id) {
        $data = $this->model->getById($id);
        echo json_encode($data ? ['success' => true, 'data' => $data]
                                : ['success' => false, 'message' => 'Course not found']);
    }
    public function store($body) {
        $ok = $this->model->create($body);
        http_response_code($ok ? 201 : 400);
        echo json_encode(['success' => $ok]);
    }
    public function update($id, $body) {
        $ok = $this->model->update($id, $body);
        echo json_encode(['success' => $ok]);
    }
    public function destroy($id) {
        $ok = $this->model->delete($id);
        echo json_encode(['success' => $ok]);
    }
    public function studentsPerCourse() {
        $stmt = $this->model->studentsPerCourse();
        echo json_encode(['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    }
}