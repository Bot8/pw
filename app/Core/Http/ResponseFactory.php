<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 21:47
 */

namespace App\Core\Http;

class ResponseFactory
{
    protected function makeResponse()
    {
        return new Response();
    }

    public function success(string $content, string $contentType = null)
    {
        $response =
            $this->makeResponse()
                 ->setResponseCode(Response::HTTP_OK_CODE)
                 ->setContent($content)
                 ->setResponseStatus(Response::HTTP_OK_STATUS);

        if ($contentType) {
            $response->setContentType($contentType);
        }

        return $response;
    }

    public function notFound()
    {
        return
            $this->makeResponse()
                 ->setResponseCode(Response::HTTP_NOT_FOUND_CODE)
                 ->setResponseStatus(Response::HTTP_NOT_FOUND_STATUS);
    }
}