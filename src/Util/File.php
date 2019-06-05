<?php

namespace App\Util;

class File
{
    private $file;
    private $path;
    private $fileName;

    public function __construct(string $path, string $fileName, bool $create = false)
    {
        $this->path = $path;
        $this->fileName = $fileName;
        $this->file = $path . $fileName;

        if ($create && !$this->isExist()) {
            file_put_contents($this->file, '');
        }
    }

    public function getName(): string
    {
        return $this->fileName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFullName(): string
    {
        return $this->file;
    }

    public function isExist(): bool
    {
        return file_exists($this->file);
    }

    public function getWeight(): int
    {
        return filesize($this->file);
    }

    public function delete(): bool
    {
        if (!$this->isWritable()) {
            return false;
        }

        return unlink($this->file);
    }

    public function clear(): bool
    {
        if (!$this->isWritable()) {
            return false;
        }

        return file_put_contents($this->file, '');
    }

    public function append(string $message): bool
    {
        if (!$this->isWritable()) {
            return false;
        }

        return file_put_contents($this->file, $message, FILE_APPEND);
    }

    public function isWritable(): bool
    {
        return $this->isExist() && is_writable($this->file);
    }

    public function getContent(): string
    {
        if (!$this->isExist()) {
            return '';
        }

        return file_get_contents($this->file);
    }

    public static function getInstanceFromPath(string $path): File
    {
        $pathInfo = self::getPathInfo($path);
        return new self($pathInfo['path'], $pathInfo['fileName']);
    }

    public static function getPathInfo(string $path): array
    {
        return [
            'path' => substr($path, 0, strrpos($path, '/') + 1),
            'fileName' => substr($path, strrpos($path, '/') + 1, strlen($path))
        ];
    }
}