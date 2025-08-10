<?php
require_once __DIR__ . '/classes/FileManager.php';
require_once __DIR__ . '/classes/Student.php';
require_once __DIR__ . '/classes/SessionManager.php';

$session = new SessionManager();
$session->requireAuth();

$fm = new FileManager(__DIR__ . '/data/students.json');
$studentModel = new Student($fm);
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $age = (int)$_POST['age'];
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    if ($name === '' || $email === '' || $course === '') {
        $error = 'Please fill all required fields.';
    } else {
        $studentModel->add([ 'name'=>$name, 'age'=>$age, 'email'=>$email, 'course'=>$course ]);
        header('Location: index.php');
        exit;
    }
}
?>

<!doctype html>
<html>
<head><meta charset="utf-8"><title>Add Student</title></head>
<body>
<h2>Add Student</h2>
<?php if ($error) echo '<p style="color:red">'.htmlspecialchars($error).'</p>'; ?>
<form method="post" action="">
    <label>Name: <input name="name" required></label><br>
    <label>Age: <input name="age" type="number" min="1" required></label><br>
    <label>Email: <input name="email" type="email" required></label><br>
    <label>Course: <input name="course" required></label><br>
    <button type="submit">Add</button>
</form>
<p><a href="index.php">Back</a></p>
</body>
</html>
