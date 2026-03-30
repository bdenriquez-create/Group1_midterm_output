<?php
// api/index.php  ← entry point for ALL requests

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Pre-flight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/StudentController.php';
require_once __DIR__ . '/controllers/CourseController.php';
require_once __DIR__ . '/controllers/EnrollmentController.php';

// ── DB connection ───────────────────────────────────────────
$db = (new Database ())->connect();

// ── Parse request ───────────────────────────────────────────
$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Strip a base prefix if the project lives in a sub-folder.
// If your server root is /api, set $base = '/api'.
// If Apache/Nginx points directly to this folder, set $base = ''.
$base = '/student_enrollment/api';                   // ← adjust as needed
$path = preg_replace('#^' . preg_quote($base, '#') . '#', '', $uri);
$path = trim($path, '/');

$segments = explode('/', $path);  // e.g. ['students', '3', 'analytics', 'total']

$resource  = $segments[0] ?? '';
$id        = isset($segments[1]) && is_numeric($segments[1]) ? (int)$segments[1] : null;
$subAction = $segments[2] ?? '';   // e.g. 'analytics'
$subDetail = $segments[3] ?? '';   // e.g. 'total'

$body = json_decode(file_get_contents('php://input'), true) ?? [];

// ── Route: /students ────────────────────────────────────────
if ($resource === 'students') {
    $ctrl = new StudentController($db);

    // /students/analytics/total
    if ($id === null && $subAction === 'analytics' && $subDetail === 'total') {
        if ($method === 'GET') { $ctrl->totalCount(); exit; }
    }

    match (true) {
        $method === 'GET'    && $id === null => $ctrl->index(),
        $method === 'GET'    && $id !== null => $ctrl->show($id),
        $method === 'POST'                   => $ctrl->store($body),
        $method === 'PUT'    && $id !== null => $ctrl->update($id, $body),
        $method === 'DELETE' && $id !== null => $ctrl->destroy($id),
        default => respond404()
    };
    exit;
}

// ── Route: /courses ─────────────────────────────────────────
if ($resource === 'courses') {
    $ctrl = new CourseController($db);

    // /courses/analytics/students-per-course
    if ($id === null && $subAction === 'analytics' && $subDetail === 'students-per-course') {
        if ($method === 'GET') { $ctrl->studentsPerCourse(); exit; }
    }

    match (true) {
        $method === 'GET'    && $id === null => $ctrl->index(),
        $method === 'GET'    && $id !== null => $ctrl->show($id),
        $method === 'POST'                   => $ctrl->store($body),
        $method === 'PUT'    && $id !== null => $ctrl->update($id, $body),
        $method === 'DELETE' && $id !== null => $ctrl->destroy($id),
        default => respond404()
    };
    exit;
}

// ── Route: /enrollments ─────────────────────────────────────
if ($resource === 'enrollments') {
    $ctrl = new EnrollmentController($db);

    // /enrollments/analytics/per-semester
    if ($id === null && $subAction === 'analytics' && $subDetail === 'per-semester') {
        if ($method === 'GET') { $ctrl->perSemester(); exit; }
    }

    // /enrollments/student/{studentId}
    if ($subAction === 'student' && isset($segments[2]) && is_numeric($segments[2])) {
        if ($method === 'GET') { $ctrl->byStudent((int)$segments[2]); exit; }
    }

    // /enrollments/course/{courseId}
    if ($subAction === 'course' && isset($segments[2]) && is_numeric($segments[2])) {
        if ($method === 'GET') { $ctrl->byCourse((int)$segments[2]); exit; }
    }

    match (true) {
        $method === 'GET'    && $id === null => $ctrl->index(),
        $method === 'GET'    && $id !== null => $ctrl->show($id),
        $method === 'POST'                   => $ctrl->store($body),
        $method === 'PUT'    && $id !== null => $ctrl->update($id, $body),
        $method === 'DELETE' && $id !== null => $ctrl->destroy($id),
        default => respond404()
    };
    exit;
}

// ── 404 fallback ────────────────────────────────────────────
respond404();

function respond404(): void {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Endpoint not found']);
}