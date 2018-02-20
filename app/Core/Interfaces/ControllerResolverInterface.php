<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 22:10
 */

namespace App\Core\Interfaces;


use App\Core\Http\Request;
use App\Core\Http\Response;

interface ControllerResolverInterface
{
    /**
     * @param Request $request
     * @return Response
     */
    public function resolve(Request $request);
}