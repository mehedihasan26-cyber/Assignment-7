<?php
require_once __DIR__ . '/classes/FileManager.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/SessionManager.php';

$fm = new FileManager(__DIR__ . '/data/users.json');
$userModel = new User($fm);
$session = new SessionManager();

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($userModel->authenticate($username, $password)) {
        $session->login($username);
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid credentials.';
    }
}
?>

<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login</title></head>
<body>
<h2>Login</h2>
<?php if ($error) echo '<p style="color:red">'.htmlspecialchars($error).'</p>'; ?>
<form method="post" action="">
    <label>Username: <input name="username" required></label><br>
    <label>Password: <input name="password" type="password" required></label><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
