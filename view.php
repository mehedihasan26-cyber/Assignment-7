<?php
require_once __DIR__ . '/classes/FileManager.php';
require_once __DIR__ . '/classes/Student.php';
require_once __DIR__ . '/classes/SessionManager.php';

$session = new SessionManager();
$session->requireAuth();
$fm = new FileManager(__DIR__ . '/data/students.json');
$studentModel = new Student($fm);
$id = (int)($_GET['id'] ?? 0);
$student = $studentModel->find($id);
if (!$student) { echo 'Not found'; exit; }
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>View Student</title></head>
<body>
<h2>View Student</h2>
<p><strong>ID:</strong> <?=htmlspecialchars($student['id'])?></p>
<p><strong>Name:</strong> <?=htmlspecialchars($student['name'])?></p>
<p><strong>Age:</strong> <?=htmlspecialchars($student['age'])?></p>
<p><strong>Email:</strong> <?=htmlspecialchars($student['email'])?></p>
<p><strong>Course:</strong> <?=htmlspecialchars($student['course'])?></p>
<p><a href="index.php">Back</a></p>
</body>
</html>
