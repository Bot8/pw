<?php

namespace App\DAO\Database;

use App\Model\Page as PageModel;
use App\Model\Link as LinkModel;

class PageFactory
{
    /**
     * @param array $page
     * @param array $link
     *
     * @return PageModel
     */
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