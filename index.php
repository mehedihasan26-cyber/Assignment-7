<?php
require_once __DIR__ . '/classes/FileManager.php';
require_once __DIR__ . '/classes/Student.php';
require_once __DIR__ . '/classes/SessionManager.php';

$session = new SessionManager();
$session->requireAuth();

$fm = new FileManager(__DIR__ . '/data/students.json');
$studentModel = new Student($fm);
$students = $studentModel->all();
?>

<!doctype html>
<html>
<head><meta charset="utf-8"><title>Students</title></head>
<body>
<h2>Students - Logged in as: <?=htmlspecialchars($session->user())?></h2>
<p><a href="add.php">Add Student</a> | <a href="logout.php">Logout</a></p>
<table border="1" cellpadding="6" cellspacing="0">
    <tr><th>ID</th><th>Name</th><th>Age</th><th>Email</th><th>Course</th><th>Actions</th></tr>
    <?php foreach ($students as $s): ?>
    <tr>
        <td><?=htmlspecialchars($s['id'])?></td>
        <td><?=htmlspecialchars($s['name'])?></td>
        <td><?=htmlspecialchars($s['age'])?></td>
        <td><?=htmlspecialchars($s['email'])?></td>
        <td><?=htmlspecialchars($s['course'])?></td>
        <td>
            <a href="view.php?id=<?=urlencode($s['id'])?>">View</a> |
            <a href="edit.php?id=<?=urlencode($s['id'])?>">Edit</a> |
            <a href="delete.php?id=<?=urlencode($s['id'])?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
