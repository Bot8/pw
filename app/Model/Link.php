<?php

namespace App\Model;

use App\Core\Model;

class Link extends Model
{
    public $id;
    public $link;
    public $page;

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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }
}