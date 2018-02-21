<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 22:28
 */

namespace App\Controller;

use App\Repository\PageRepository;
use App\Core\Controller\AbstractController;

class PageController extends AbstractController
{
    /** @var PageRepository */
    protected $repository;

    /**
     * PageController constructor.
     *
     * @param PageRepository $repository
     */
    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function readFile(string $file)
    {
        $model = $this->repository->getByFileName($file);

        return $this->responseFactory->success("file {$file} " . var_export($model, true));
    }

    public function readPage(string $page)
    {
        $model = $this->repository->getByLink($page);

        if (is_null($model)) {
            return $this->responseFactory->notFound();
        }

        return $this->responseFactory->success(var_export($model, true));
    }
}