<?php

namespace App\Core\Storage;

class Filesystem
{
    protected $dir;

    protected $mimeTypes = [
        'txt'  => 'text/plain',
        'htm'  => 'text/html',
        'html' => 'text/html'
    ];

    /**
     * Filesystem constructor.
     *
     * @param $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function detectMimeType(string $file)
    {
        $type = array_pop(explode('.', $file));

        return $this->mimeTypes[$type] ?? mime_content_type($file);
    }

    public function find(string $name)
    {
        $file = "{$this->dir}/{$name}";

        if (!file_exists($file)) {
            return null;
        }

        return [
            'mime'  => $this->detectMimeType($file),
            'title' => $name,
            'text'  => file_get_contents($file)
        ];
    }
}