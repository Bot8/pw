<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 22:28
 */

namespace App\Controller;

use App\Core\Http\ResponseFactory;
use App\Core\Controller\AbstractController;

class PageController extends AbstractController
{
    public function readFile(string $file)
    {
        return ResponseFactory::success("file {$file}");
    }

    public function readPage(string $page)
    {
        return ResponseFactory::success("page {$page}");
    }


}