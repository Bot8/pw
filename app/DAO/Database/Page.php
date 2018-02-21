<?php

namespace App\DAO\Database;

use App\Model\Page as PageModel;
use App\Model\Link as LinkModel;

class Page
{
    public function makePage(array $page, array $link = [])
    {
        $page = new PageModel($page);

        if (empty($link)) {
            return $page;
        }

        $link = new LinkModel($link);

        $page->link = $link;

        $link->page = $page;

        return $page;
    }
}