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
    protected static function makeResponse()
    {
        return new Response();
    }

    public static function success(string $content, string $contentType = null)
    {
        $response = self::makeResponse()
            ->setResponseCode(Response::HTTP_OK_CODE)
            ->setContent($content)
            ->setResponseStatus(Response::HTTP_OK_STATUS);

        if ($contentType) {
            $response->setContentType($contentType);
        }

        return $response;
    }

    public static function notFound()
    {
        return self::makeResponse()
            ->setResponseCode(Response::HTTP_NOT_FOUND_CODE)
            ->setResponseStatus(Response::HTTP_NOT_FOUND_STATUS);
    }
}