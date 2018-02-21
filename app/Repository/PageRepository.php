<?php

namespace App\Repository;

use App\Model\Page;

class PageRepository
{
    public function getByLink(string $link)
    {
        return new Page();
    }

    public function getByFileName(string $fileName)
    {
        return new Page();
    }
}