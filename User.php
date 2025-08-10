<?php
require_once __DIR__ . '/FileManager.php';

class User {
    private $fileManager;

    public function __construct(FileManager $fm) {
        $this->fileManager = $fm;
    }

    // Supports both hashed passwords (password_hash) and plain-text for simplicity.
    public function authenticate(string $username, string $password): bool {
        $users = $this->fileManager->read();
        foreach ($users as $u) {
            if (!isset($u['username']) || !isset($u['password'])) continue;
            if ($u['username'] === $username) {
                // If stored password is a hash, password_verify should succeed.
                if (password_verify($password, $u['password'])) return true;
                // Fallback for plain-text (simple setups)
                if ($u['password'] === $password) return true;
            }
        }
        return false;
    }

    public function findUser(string $username): ?array {
        $users = $this->fileManager->read();
        foreach ($users as $u) {
            if ($u['username'] === $username) return $u;
        }
        return null;
    }
}
