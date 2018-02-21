<?php

namespace App\View;

use App\Core\View;
use App\Model\Page;
use App\Core\Helpers\TextContentConverter;

class PageView extends View
{
    const CONVERTIBLE_MIME_TYPE = 'text/plain';

    public function __construct(string $template, Page $page)
    {
        parent::__construct($template);

        $content = $page->getText();

        if (self::CONVERTIBLE_MIME_TYPE === $page->getMime()) {
            $content = TextContentConverter::convert($page->getText());
        }

        $this->assign('title', $page->getTitle())
             ->assign('content', $content);
    }

}