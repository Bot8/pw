<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 22:24
 */

namespace App\Core\Controller;

use App\Core\Http\Request;
use App\Core\Http\ResponseFactory;

class AbstractController
{
    /** @var Request */
    protected $request;

    /** @var ResponseFactory */
    protected $responseFactory;

    /**
     * @param Request $request
     *
     * @return AbstractController
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param ResponseFactory $responseFactory
     */
    public function setResponseFactory(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

}