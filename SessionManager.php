<?php
class SessionManager {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function login(string $username) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public function check(): bool {
        return !empty($_SESSION['logged_in']) && !empty($_SESSION['username']);
    }

    public function requireAuth() {
        if (!$this->check()) {
            header('Location: login.php');
            exit;
        }
    }

    public function user(): ?string {
        return $_SESSION['username'] ?? null;
    }
}
