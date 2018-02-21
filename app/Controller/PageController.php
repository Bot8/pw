<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 22:28
 */

namespace App\Controller;

use App\View\PageView;
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

        if (is_null($model)) {
            return $this->responseFactory->notFound();
        }

        return $this->responseFactory->success(new PageView('page', $model));
    }

    public function readPage(string $page)
    {
        $model = $this->repository->getByLink($page);

        if (is_null($model)) {
            return $this->responseFactory->notFound();
        }

        return $this->responseFactory->success(new PageView('page', $model));
    }
}