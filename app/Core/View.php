<?php

namespace App\Core;

class View
{
    protected $viewDir;

    protected $template;

    protected $vars = [];

    /**
     * View constructor.
     *
     * @param $template
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * @param mixed $viewDir
     *
     * @return View
     */
    public function setViewDir(string $viewDir)
    {
        $this->viewDir = $viewDir;

        return $this;
    }

    public function assign(string $key, string $value)
    {
        $this->vars[$key] = $value;

        return $this;
    }

    public function render()
    {
        $content = file_get_contents("{$this->viewDir}/{$this->template}.html");

        foreach ($this->vars as $key => $value) {
            $content = str_replace("{{$key}}", $value, $content);
        }

        return $content;
    }

    public function __toString()
    {
        return $this->render();
    }
}