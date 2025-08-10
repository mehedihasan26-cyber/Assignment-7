<?php
require_once __DIR__ . '/classes/FileManager.php';
require_once __DIR__ . '/classes/Student.php';
require_once __DIR__ . '/classes/SessionManager.php';

$session = new SessionManager();
$session->requireAuth();
$fm = new FileManager(__DIR__ . '/data/students.json');
$studentModel = new Student($fm);
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $studentModel->delete($id);
}
header('Location: index.php');
exit;
