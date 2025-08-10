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
if (!$student) {
    echo 'Student not found'; exit;
}
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $age = (int)$_POST['age'];
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    if ($name === '' || $email === '' || $course === '') {
        $error = 'Please fill all required fields.';
    } else {
        $studentModel->update($id, ['name'=>$name,'age'=>$age,'email'=>$email,'course'=>$course]);
        header('Location: index.php');
        exit;
    }
}
?>

<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Student</title></head>
<body>
<h2>Edit Student</h2>
<?php if ($error) echo '<p style="color:red">'.htmlspecialchars($error).'</p>'; ?>
<form method="post" action="">
    <label>Name: <input name="name" value="<?=htmlspecialchars($student['name'])?>" required></label><br>
    <label>Age: <input name="age" type="number" min="1" value="<?=htmlspecialchars($student['age'])?>" required></label><br>
    <label>Email: <input name="email" type="email" value="<?=htmlspecialchars($student['email'])?>" required></label><br>
    <label>Course: <input name="course" value="<?=htmlspecialchars($student['course'])?>" required></label><br>
    <button type="submit">Save</button>
</form>
<p><a href="index.php">Back</a></p>
</body>
</html>
