<?php
class FileManager {
    private $path;
    public function __construct($path) {
        $this->path = $path;
        if (!file_exists($this->path)) {
            file_put_contents($this->path, json_encode([]));
        }
    }

    public function read(): array {
        $content = @file_get_contents($this->path);
        if ($content === false || trim($content) === '') return [];
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    public function write(array $data): bool {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $fp = fopen($this->path, 'c+');
        if (!$fp) return false;
        flock($fp, LOCK_EX);
        ftruncate($fp, 0);
        rewind($fp);
        $written = fwrite($fp, $json);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
        return $written !== false;
    }
}
