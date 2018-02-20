<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 22:24
 */

namespace App\Core\Controller;

use App\Core\Http\Request;

class AbstractController
{
    protected $request;

    /**
     * @param Request $request
     * @return AbstractController
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}