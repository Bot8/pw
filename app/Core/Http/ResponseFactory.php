<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 21:47
 */

namespace App\Core\Http;

use App\Core\View;

class ResponseFactory
{
    protected $viewDir;

    protected $pageNotFoundView;

    /**
     * ResponseFactory constructor.
     *
     * @param string $viewDir
     * @param View   $pageNotFoundView
     */
    public function __construct(string $viewDir, View $pageNotFoundView)
    {
        $this->viewDir = $viewDir;
        $this->pageNotFoundView = $this->prepareView($pageNotFoundView);
    }

    protected function makeResponse()
    {
        return new Response();
    }

    protected function prepareView(View $view)
    {
        $view->setViewDir($this->viewDir);

        return $view;
    }

    public function success(View $view)
    {
        $response =
            $this->makeResponse()
                 ->setResponseCode(Response::HTTP_OK_CODE)
                 ->setContent($this->prepareView($view)->render())
                 ->setResponseStatus(Response::HTTP_OK_STATUS);

        return $response;
    }

    public function notFound()
    {
        return
            $this->makeResponse()
                 ->setResponseCode(Response::HTTP_NOT_FOUND_CODE)
                 ->setContent($this->pageNotFoundView->render())
                 ->setResponseStatus(Response::HTTP_NOT_FOUND_STATUS);
    }
}