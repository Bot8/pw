<?php

namespace App\Model;

use App\Core\Model;

class Page extends Model
{
    public $id;
    public $mime;
    public $title;
    public $text;
    public $link;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return Link
     */
    public function getLink()
    {
        return $this->link;
    }
}