<?php
require_once __DIR__ . '/FileManager.php';

class Student {
    private $fileManager;

    public function __construct(FileManager $fm) {
        $this->fileManager = $fm;
    }

    public function all(): array {
        return $this->fileManager->read();
    }

    public function find(int $id): ?array {
        $students = $this->all();
        foreach ($students as $s) {
            if ((int)$s['id'] === $id) return $s;
        }
        return null;
    }

    public function add(array $data): bool {
        $students = $this->all();
        $ids = array_column($students, 'id');
        $next = $ids ? max($ids) + 1 : 1;
        $data['id'] = $next;
        $students[] = $data;
        return $this->fileManager->write($students);
    }

    public function update(int $id, array $data): bool {
        $students = $this->all();
        foreach ($students as &$s) {
            if ((int)$s['id'] === $id) {
                $s['name'] = $data['name'] ?? $s['name'];
                $s['age'] = $data['age'] ?? $s['age'];
                $s['email'] = $data['email'] ?? $s['email'];
                $s['course'] = $data['course'] ?? $s['course'];
                return $this->fileManager->write($students);
            }
        }
        return false;
    }

    public function delete(int $id): bool {
        $students = $this->all();
        $new = [];
        $deleted = false;
        foreach ($students as $s) {
            if ((int)$s['id'] === $id) { $deleted = true; continue; }
            $new[] = $s;
        }
        if (!$deleted) return false;
        return $this->fileManager->write($new);
    }
}
